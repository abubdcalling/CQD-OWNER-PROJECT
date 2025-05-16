<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerListResource;
use App\Models\Customer;
use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->limit;
        if (!$page && $page < 1) {
            $page = 10;
        }
        $posts = Post::latest()->when($request->search,function($query,$value){
            $query->where('title','like','%'.$value.'%');
        })->paginate($page);
        return Helper::jsonResponse(true,'Blogs retrieved successfully.',200,$posts,true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'published' => 'required|boolean',
            'tags' => 'required|array',
            'meta_keywords' => 'nullable|string|max:2000',
        ]);


        try {
            //store image to public folder
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $path = Helper::fileUpload($image,'posts/image',getFileName($image));
            }else{
                $path = 'uploads/posts/image/default.jpg';
            }

            $validated['image'] = $path;

            $tags = $request->tags ?? [];
            unset($validated['tags']);
            $post = Post::create($validated);

            foreach ($tags as $tag) {
                $tag = Tags::firstOrCreate(['name'=>$tag], ['name'=>$tag]);
                $post->tags()->attach($tag->id);
            }

            $post->load('tags');
            return Helper::jsonResponse(true,'Blog created successfully.',200,$post);
        }catch (\Exception $exception){
            return Helper::jsonResponse(false,$exception->getMessage(),500);
        }
    }

    public function show(string $id){
        $post = Post::find($id);
        if (!$post) {
            return Helper::jsonResponse(false,'Blog not found',404);
        }
        $post->load('tags');
        return Helper::jsonResponse(true,'Blog retrieved successfully.',200,$post);
    }

    public function update(Request $request, string $id){
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:posts,slug,'.$id,
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'sometimes|required|string',
            'published' => 'sometimes|required|boolean',
            'tags' => 'sometimes|required|array',
            'meta_keywords' =>  'sometimes|nullable|string|max:2000',
        ]);


        try {
            $post = Post::find($id);
            if (!$post) {
                return Helper::jsonResponse(false,'Blog not found.',404);
            }
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $path = Helper::fileUpload($image,'posts/image',getFileName($image));

                //delete existing files
                if($post->image && file_exists(public_path($post->image))){
                    Helper::fileDelete(public_path($post->image));
                }
            }else{
                $path = $post->image;
            }

            $validated['image'] = $path;

            $tags = $request->tags ?? [];
            unset($validated['tags']);
            $post->update($validated);

            $tagsSt = [];
            foreach ($tags as $tag) {
                $tag = Tags::firstOrCreate(['name'=>$tag], ['name'=>$tag]);
                if($tag?->id){
                    $tagsSt[] = $tag->id;
                }
            }
            if ($request->tags && count($tagsSt) > 0) {
                $post->tags()->sync($tagsSt);
            }
            $post->load('tags');
            return Helper::jsonResponse(true,'Blog updated successfully.',200,$post);
        }catch (\Exception $exception){
            return Helper::jsonResponse(false,$exception->getMessage(),500);
        }
    }

    public function destroy(string $id){
        try {
            $post = Post::find($id);
            if (!$post) {
                return Helper::jsonResponse(false,'Blog not found',404);
            }
            if($post->image && file_exists(public_path($post->image))){
                Helper::fileDelete(public_path($post->image));
            }
            $post->delete();
            return Helper::jsonResponse(true,'Blog deleted successfully.',200);
        }catch (\Exception $exception){
            return Helper::jsonResponse(false,$exception->getMessage(),500);
        }
    }

    public function status(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return Helper::jsonResponse(false,'Blog not found',404);
        }
        if ($post->published) {
            $post->update(['published' => false]);
        }else{
            $post->update(['published' => true]);
        }

        return Helper::jsonResponse(true,'Blog status updated successfully.',200,$post);
    }

    public function getTags(){
        return Helper::jsonResponse(true,'Tags retrieved successfully.',200,Tags::all());
    }
}
