<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
       $validatedData = $request->validate([
            'first_name'=>'required|string|max:100',
            'last_name'=>'required|string|max:100',
            'email'=>'required|email|max:100',
            'phone'=>'required|phone',
            'message'=>'required|string|max:1000',
             'organisation' => 'required|string|max:100',
       ],[
            'phone.phone'=>'Phone number must be a valid phone number',
       ]);

        try {
            $validatedData['name'] = $request->input('first_name').' '.$request->input('last_name');
            Mail::to('mark@cqdcleaningservices.com')->send(new ContactMail($validatedData));
            return Helper::jsonResponse(true,'Thanks for contacting us!',201);
        }catch (\Exception $exception){
            return Helper::jsonResponse(false,$exception->getMessage(),500);
        }
    }
}
