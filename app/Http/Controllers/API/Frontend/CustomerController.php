<?php

namespace App\Http\Controllers\API\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Mail\CustomerApplication;
use App\Mail\CustomerApplicationNotifier;
use App\Mail\GroupFullAdminNotifier;
use App\Mail\GroupFullMail;
use App\Models\Customer;
use App\Models\Group;
use App\Models\IncompleteApplication;
use App\Models\Package;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function subscribe(SubscribeRequest $request){

        $validated = $request->validated();
        try {
            \DB::beginTransaction();
            $googleAddress = $this->getAddressFromLatLng($validated['lat'],$validated['lng']);
            if (!$googleAddress['success']) {
                return Helper::jsonErrorResponse($googleAddress['message'], 400, $googleAddress['error'] ?? []);
            }
            foreach($googleAddress['data'] ?? [] as $index => $item){
                if (!$item){
                    unset($googleAddress['data'][$index]);
                }
            }
            $validated = array_merge($validated, $googleAddress['data']);
            $customer = Customer::create([
                'company_name' => $validated['company_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'zip_code' => $validated['zip_code'],
                'address' => $validated['address'],
                'lat' => $validated['lat'],
                'lng' => $validated['lng'],
                'package_id' => $validated['package_id'],
            ]);

            $package = Package::find($validated['package_id']);

            $nearestCustomer = Customer::findUsersWithinRadius($validated['lat'], $validated['lng'], $validated['zip_code'], $validated['package_id'])->orderBy('created_at','asc')->first();
            $group = $nearestCustomer?->group;
            if ($group && $group->total_members > $group->members_count) {
                $customer->update(['group_id' => $group->id]);
            } else {
                $group = Group::create([
                    'zip_code' => $validated['zip_code'],
                    'total_members' => $package->number_of_client,
                    'package_id' => $validated['package_id'],
                ]);
                $customer->update(['group_id' => $group->id]);
            }

            $admins = User::where('role','admin')->get();

            $group->load(['members']);
            $member_count = count($group->members);

            foreach ($admins as $admin){
                $admin->notify(new AdminNotification("New Application for ".$package->title,$customer,'single',$package->title));
                Mail::to($admin->email)->send(new CustomerApplicationNotifier($package,$customer,$member_count,$customer->created_at->format('Y-m-d')));
            }

            IncompleteApplication::where('email',$request->email)?->delete();

            //send email to customer
            Mail::to($customer->email)->send(new CustomerApplication($package, $customer));

            //send email if group is full
            if ($member_count == $group->total_members) {
                foreach ($group->members as $customer) {
                    Mail::to($customer->email)->send(new GroupFullMail($package, $customer));
                }
                //send email to admin
                foreach ($admins as $admin){
                    $admin->notify(new AdminNotification("Group is full for ".$package->title,$group->members,'group',$package->title));
                    Mail::to($admin->email)->send(new GroupFullAdminNotifier($package,$group));
                }
            }
            \DB::commit();
            return Helper::jsonResponse(true,'Subscribed successfully',200,$customer->load('package'));
        }catch (\Exception $exception){
            \DB::rollBack();
            return Helper::jsonErrorResponse($exception->getMessage(),500);
        }
    }

    function getAddressFromLatLng($latitude,$longitude)
    {
        // Retrieve API key from configuration
        $apiKey = config('services.google_maps.key');
        // Build the API URL
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";
        // Make the API request
        $response = Http::get($url);
        // Handle the API response
        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['results'])) {
                // Extract the first result's address components and formatted address
                $addressComponents = $data['results'][0]['address_components'];
                $formattedAddress = $data['results'][0]['formatted_address'];
                // Define the components we want to extract
                $locationData = [
                    'country' => null,
                    'zip_code' => null,
                    'region' => null,
                    'city' => null,
                ];
                // Map the address components to the desired structure
                foreach ($addressComponents as $component) {
                    $types = $component['types'];
                    if (in_array('country', $types)) {
                        $locationData['country'] = $component['long_name'];
                    } elseif (in_array('postal_code', $types)) {
                        $locationData['zip_code'] = $component['long_name'];
                    } elseif (in_array('administrative_area_level_1', $types)) {
                        $locationData['region'] = $component['long_name'];
                    } elseif (in_array('locality', $types)) {
                        $locationData['city'] = $component['long_name'];
                    }
                }
                // Return the extracted components
                return [
                    'success' => true,
                    'data' => $locationData,
                ];
            }
            // Return if no results were found
            return [
                'success' => false,
                'message' => $data['error_message'] ?? 'No address details found for the provided coordinates.',
            ];
        }
        // Handle API request failure
        return [
            'success' => false,
            'message' => 'Failed to fetch address details. Please try again later.',
            'error' => $response->json(),
        ];
    }

    public function personalInfoValidate(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone' => 'required|phone|string|max:255|unique:customers,phone',
        ]);

        IncompleteApplication::create([
            'company_name' => $request->company_name,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'package_id' => $request->input('package_id'),
        ]);
        return Helper::jsonResponse(true,'Validated successfully',200);
    }

    public function addressValidation(Request $request)
    {
        $request->validate([
            'zip_code' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        return Helper::jsonResponse(true,'Validated successfully',200);
    }

    public function incompleteApplication(string $id)
    {
        $incompleteApplication = IncompleteApplication::find($id);
        if (!$incompleteApplication) {
            return Helper::jsonResponse(false,'Incomplete application not found',404);
        }
        return Helper::jsonResponse(true,'Incomplete application found',200,$incompleteApplication);
    }
}
