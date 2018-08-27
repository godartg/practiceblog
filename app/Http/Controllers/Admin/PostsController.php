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

        $post = Post::create( $request->only('title') );
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
        // return $request;

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
        $post->iframe = $request->get('iframe');
        $post->excerpt = $request->get('excerpt');
        $post->published_at = $request->get('published_at') == null 
                                ? null
                                : Carbon::parse($request->get('published_at'));

        $post->category_id = Category::find($cat = $request->get('category'))
                                ? $cat
                                : Category::create(['name' => $cat])->id;
        $post->save();

        $tags = [];
        foreach ($request->get('tags') as $tag) {
            $tags[] = Tag::find($tag)
                    ? $tag
                    : Tag::create(['name' => $tag])->id;
        }


        $post->tags()->sync($tags);

        return redirect()->route('admin.posts.edit',$post)->with('flash','tu publicación ha sido guardada');
    }
}
