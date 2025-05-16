<?php
Route::get('/',function (){
//    $googleService->getProfile();
    Artisan::call('migrate',['--force'=>true]);
     return response()->json([
         'message' => 'Hello World!',
         'logo' => asset('logo.png')
     ]);
});
