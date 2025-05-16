<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(string $type)
    {
        $package = Package::where('type', $type)->first();
        if (!$package) {
            return Helper::jsonErrorResponse('Package not found', 404);
        }
        return Helper::jsonResponse(true,'Successfully fetch the package.', 200,$package);
    }

    public function update(Request $request, $type)
    {
       $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:1',
            'number_of_client' => 'sometimes|required|numeric|min:1',
            'val_type' => 'sometimes|required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

       $package = Package::where('type',$type)->first();

        if ($request->hasFile('thumbnail')) {
            $thumbnail = Helper::fileUpload($request->file('thumbnail'), 'package/thumbnails',getFileName($request->file('thumbnail')));
        }else{
            $thumbnail = $package->thumbnail;
        }
        $validatedData['thumbnail'] = $thumbnail;
        $package->update($validatedData);
        return Helper::jsonResponse(true,'Successfully updated the package.', 200,$package);
    }

}
