<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\GroupListResource;
use App\Http\Resources\SingleCustomerResource;
use App\Mail\GroupMemberMail;
use App\Models\Customer;
use App\Models\Group;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->limit;
        if (!$page && $page < 1) {
            $page = 10;
        }
        $customers = Customer::latest()->with(['package'])->when($request?->package,function ($query,$value){
            $query->whereHas('package',function ($q) use ($value){
                $q->where('type',$value);
            });
        })->with(['company'])->paginate($page);
        return Helper::jsonResponse(true,'Customers List',200,CustomerListResource::collection($customers),true,$customers);
    }

    public function availableZipCodes()
    {
        $zipCodes = Customer::select('zip_code')->distinct()->get();
        return Helper::jsonResponse(true,'Available Zip Codes',200,$zipCodes);
    }

    public function availableRegions()
    {
        $regions = Customer::select('region')->distinct()->get();
        return Helper::jsonResponse(true,'Available Regions',200,$regions);
    }

    public function group(Request $request)
    {
        $page = $request->limit;
        if (!$page && $page < 1) {
            $page = 10;
        }
        $group = Group::with(['package'])->when($request?->package,function ($query,$value){
            $query->whereHas('package',function ($q) use ($value){
                $q->where('type',$value);
            });
        })->when($request->is_group_full,function ($query,$value){
            if ($value == 'true') {
                $query->whereRaw(
                    'total_members = (SELECT COUNT(*) FROM customers WHERE groups.id = customers.group_id)'
                );
            } elseif ($value == 'false') {
                $query->whereRaw(
                    'total_members > (SELECT COUNT(*) FROM customers WHERE groups.id = customers.group_id)'
                );
            }
        })->when($request?->zip_code,function ($query,$value){
            $query->where('zip_code',$value);
        })->when($request?->date,function ($query,$value){
            $query->whereDate('created_at',$value);
        })->with(['package'])->latest()->paginate($page);
        return Helper::jsonResponse(true,'Customer Groups',200,GroupListResource::collection($group),true,$group);
    }

    //get single customer group
    public function singleGroup($id)
    {
        $group = Group::with(['package'])->find($id);
        if (!$group) {
            return Helper::jsonResponse(false,'Group not found',404);
        }
        return Helper::jsonResponse(true,'Customer Group',200,SingleCustomerResource::collection($group->members));
    }


    public function sendGroupMemberMail(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $group = Group::with('members')->find($request->group_id);
        if (!$group) {
            return Helper::jsonResponse(false,'Group not found',404);
        }
        $subject = $request->subject;
        $message = $request->message;

        foreach ($group->members as $customer) {
            \Mail::to($customer->email)->send(new GroupMemberMail($subject, $message, $customer));
        }
        return Helper::jsonResponse(true,'Mail Sent',200);
    }
}
