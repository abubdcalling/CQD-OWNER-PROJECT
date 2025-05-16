<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        return Helper::jsonResponse(true, 'Successfully fetch the settings', 200, SystemSetting::first());
    }


    public function update(Request $request)
    {
        $settings = SystemSetting::first();
        if(!$settings){
            $validatedData = $request->validate([
                'address' => 'required|string|max:255',
                'email' => 'required|email|max:100',
                'company_open_hour' => 'required|string|max:255',
                'contact_number' => 'required|string|phone',
                'description' => 'required|string|max:255',
                'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'system_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
//            'copyright_text' => 'required|string|max:255',
            ]);
        }else{
            $validatedData = $request->validate([
                'address' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|max:100',
                'company_open_hour' => 'sometimes|required|string|max:255',
                'contact_number' => 'sometimes|required|string|phone',
                'description' => 'sometimes|required|string|max:1000',
                'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'system_name' => 'sometimes|required|string|max:255',
                'title' => 'sometimes|required|string|max:255',
//            'copyright_text' => 'required|string|max:255',
            ]);
        }


       $settings = SystemSetting::first();
        if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
            if ($settings && $settings->favicon && file_exists(public_path($settings->favicon))) {
                Helper::fileDelete(public_path($settings->favicon));
            }
            $favicon = Helper::fileUpload($request->file('favicon'), 'settings', getFileName($request->file('favicon')));
        } else {
            $favicon = $settings?->favicon;
        }
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($settings && $settings->logo && file_exists(public_path($settings->logo))) {
                Helper::fileDelete(public_path($settings->logo));
            }
            $logo = Helper::fileUpload($request->file('logo'), 'settings', getFileName($request->file('logo')));
        } else {
            $logo = $settings?->logo;
        }
        $validatedData['favicon'] = $favicon;
        $validatedData['logo'] = $logo;
        if ($settings) {
            $settings->update($validatedData);
        }else{
            $settings = SystemSetting::create($validatedData);
        }

        \Cache::forget('logo');
        \Cache::forget('settings');

        return Helper::jsonResponse(true, 'Successfully updated the settings.', 200, $settings);
    }
}
