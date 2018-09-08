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
    	// $posts = Post::where('user_id',auth()->id())->get();
        $posts = auth()->user()->posts;
    	return view('admin.posts.index',compact('posts'));
    }

    public function store(Request $request)
    {
        
        $this->authorize('create', new Post);

        $this->validate($request,[
            'title' => 'required|min:3',
        ]);

        // $post = Post::create( $request->only('title') );
        $post = Post::create( $request->all() );

        return redirect()->route('admin.posts.edit',$post);
    }

    public function edit(Post $post)
    {
        $this->authorize('view',$post);

        return view('admin.posts.edit',[
            'post' => $post,
            'tags' => Tag::all(),
            'categories' => Category::all()
        ]);
    }

    public function update(Post $post,StorePostRequest $request)
    {
        
        $this->authorize('update',$post);

        $post->update($request->all());
        $post->syncTags($request->get('tags'));
        
        return redirect()->route('admin.posts.edit',$post)->with('flash','tu publicación ha sido guardada');

    }

    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('flash','tu publicación ha sido eliminada');
    }
}
