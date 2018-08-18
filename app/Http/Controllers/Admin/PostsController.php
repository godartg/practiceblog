<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
