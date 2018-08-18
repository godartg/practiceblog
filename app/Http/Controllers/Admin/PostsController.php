<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Post;
use App\Category;
use App\Tag;

class PostsController extends Controller
{
    public function index()
    {
    	$posts = Post::all();
    	return view('admin.posts.index',compact('posts'));
    }

    public function create()
    {
    	$tags = Tag::all();
    	$categorias = Category::all();
    	return view('admin.posts.create',compact('categorias','tags'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $request->published_at = Carbon::parse($request->get('published_at'));
        // // dd($request->published_at);
        // Post::create($request->all());

        $post = new Post;
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->excerpt = $request->get('excerpt');
        $post->category_id = $request->get('category');
        $post->published_at = Carbon::parse($request->get('published_at'));

        $post->save();

        $post->tags()->attach($request->get('tags'));

        return back()->with('flash','tu publicación ha sido creada');
    }
}
