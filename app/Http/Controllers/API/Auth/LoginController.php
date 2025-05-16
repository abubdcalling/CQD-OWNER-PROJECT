<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
         $request->validate([
             'email' => 'required|string|email',
             'password' => 'required|string',
         ]);
         if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
             return Helper::jsonErrorResponse('The provided credentials do not match our records.',401,[
                 'email' => 'The provided credentials do not match our records.'
             ]);
         }

         if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) && Auth::user()->email_verified_at === null){
             return Helper::jsonErrorResponse('Email not verified.',403  ,[]);
         }

         $user = Auth::user();
         return response()->json([
             'status' => true,
             'message' => 'Login Successful',
             'token_type' => 'Bearer',
             'token' => $user->createToken('AuthToken')->plainTextToken,
             'data' => $user
         ]);
    }

    public function logout(Request $request)
    {
        try {
            // Revoke the current user’s token
            $request->user()->currentAccessToken()->delete();
            // Return a response indicating the user was logged out
            return response()->json(['message' => 'Logged out successfully.'], 200);
        }catch (\Exception $exception){
            return Helper::jsonErrorResponse($exception->getMessage(),401,[]);
        }
    }

    public function user()
    {
        return Helper::jsonResponse(true,'User Details fetch successfully.',200,Auth::user());
    }

    public function profile_update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|phone|unique:users,phone,'.Auth::user()->id,
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about' => 'sometimes|nullable|string|max:1000',
            'position' => 'sometimes|nullable|string|max:100',
            'website' => 'sometimes|nullable|string|url',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:100',
            'state' => 'sometimes|nullable|string|max:100',
            'country' => 'sometimes|nullable|string|max:100',
            'zip_code' => 'sometimes|nullable|string|max:100',
        ],[
            'phone.phone' => 'Invalid phone number',
        ]);
        try {
            $user = \auth()->user();

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                if ($user->avatar){
                    Helper::fileDelete(public_path($user->avatar));
                }
                $avatar = Helper::fileUpload($request->file('avatar'), 'user/avatar',getFileName($request->file('avatar')));
            }else{
                $avatar = $user->avatar;
            }

            $validatedData['avatar'] = $avatar;
            // Update user details
            $user->update($validatedData);
            return Helper::jsonResponse(true,'Profile updated successfully.',200,Auth::user());
        }catch (\Exception $exception){
            return Helper::jsonErrorResponse($exception->getMessage(),401,[]);
        }
    }
}
