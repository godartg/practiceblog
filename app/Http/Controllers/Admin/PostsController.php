<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function update(Post $post,StorePostRequest $request)
    {
        $post->update($request->all());

        $post->syncTags($request->get('tags'));
        
        return redirect()->route('admin.posts.edit',$post)->with('flash','tu publicación ha sido guardada');

        // dd($request->all());
        // dd($request->all());
        // $request->published_at = Carbon::parse($request->get('published_at'));
        // // dd($request->published_at);
        // Post::create($request->all());
        // return $request;

        // return $request->all();

        // $post->title = $request->get('title');
        // $post->body = $request->get('body');
        // $post->iframe = $request->get('iframe');
        // $post->excerpt = $request->get('excerpt');
        // $post->published_at = $request->get('published_at');
        // $post->category_id = $request->get('category_id');
        // $post->save();

        // $tags = collect($request->get('tags'))->map(function($tag){
        //     return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        // });

        // $post->tags()->sync($tags);
        // $tags = [];
        // foreach ($request->get('tags') as $tag) {
        //     $tags[] = Tag::find($tag)
        //             ? $tag
        //             : Tag::create(['name' => $tag])->id;
        // }



    }
}
