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

    // public function create()
    // {
    // 	$tags = Tag::all();
    // 	$categorias = Category::all();
    // 	return view('admin.posts.create',compact('categorias','tags'));
    // }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required'
        ]);

        $post = Post::create([
            'title' => $request->get('title'),
            'url'=> str_slug($request->get('title')),
            // 'excerpt' => '',
            // 'body' => '',
            // 'category_id' => 1,
            // 'published_at' => Carbon::now(),

        ]);
        return redirect()->route('admin.posts.edit',$post);
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.edit',compact('categories','tags','post'));
    }

    public function update(Post $post,Request $request)
    {
        // dd($request->all());
        // dd($request->all());
        // $request->published_at = Carbon::parse($request->get('published_at'));
        // // dd($request->published_at);
        // Post::create($request->all());

        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'tags' => 'required',
            'excerpt' => 'required'
        ]);

        $post->title = $request->get('title');
        $post->url = str_slug($request->get('title'));
        $post->body = $request->get('body');
        $post->excerpt = $request->get('excerpt');
        $post->category_id = $request->get('category');
        $post->published_at = $request->get('published_at') == null ? null: Carbon::parse($request->get('published_at'));

        $post->save();

        $post->tags()->sync($request->get('tags'));

        return back()->with('flash','tu publicación ha sido guardada');
    }
}
