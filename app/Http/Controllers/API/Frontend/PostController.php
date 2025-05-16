<?php

namespace App\Http\Controllers\API\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->limit;
        if (!$page && $page < 1) {
            $page = 10;
        }
        $posts = Post::latest()->where('published',true)->with('tags')->when($request->search,function($query,$value){
            $query->where('title','LIKE',"%{$value}%");
        })->paginate($page);
        return Helper::jsonResponse(true,'Blogs retrieved successfully.',200,$posts,true);
    }

    public function show(string $slug){
        $post = Post::with(['tags'])->where('published',true)->where('slug',$slug)->first();
        if (!$post) {
            return Helper::jsonResponse(false,'Blogs not found.',404);
        }
        $tags = $post->tags->pluck('id')->toArray();
        $relatedPosts = Post::with(['tags'])->where('published',true)->whereNot('id',$post->id)->whereHas('tags',function($query) use ($tags){
            $query->whereIn('tags.id',$tags ?? []);
        })->latest()->take(10)->get();

        $data = [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];
        return Helper::jsonResponse(true,'Blog retrieved successfully.',200,$data);
    }
}
