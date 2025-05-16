<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SeoData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeoDataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page_type' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:7000',
            'meta_keywords' => 'nullable|string|max:2000',
        ]);

        $index = $validated['page_type'];
        unset($validated['page_type']);
        SeoData::updateOrCreate(['page_type' => $index],$validated);

        return Helper::jsonResponse(true,'Seo Data updated Successfully',201,SeoData::where('page_type',$index)->first());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $type)
    {
        $metaData = SeoData::where('page_type',$type)->first();
        if(!$metaData){
            $metaData = new SeoData();
            $metaData->page_type = $type;
            $metaData->meta_title = '';
            $metaData->meta_description = '';
            $metaData->meta_keywords = '';
        }

        return Helper::jsonResponse(true,'Seo Data found',200,$metaData);
    }

}
