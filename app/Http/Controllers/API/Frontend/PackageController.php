<?php

namespace App\Http\Controllers\API\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(){
        $packages = Package::all();
        return Helper::jsonResponse(true,'Packages',200,$packages);
    }
}
