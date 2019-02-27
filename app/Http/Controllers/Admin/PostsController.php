<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Category;
use App\SocialNetwork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;

class PostsController extends Controller
{
    public function index()
    {

        $posts = Post::allowed()->get();
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
        $this->authorize('update',$post);

        return view('admin.posts.edit',[
            'post' => $post,
            'tags' => Tag::all(),
            'social_network' => SocialNetwork::all(),
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
//falta ver desde 054