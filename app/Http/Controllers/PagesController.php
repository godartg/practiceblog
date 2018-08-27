<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PagesController extends Controller
{
    public function home()
    {
    	$posts = Post::published()->paginate(); //por de fececto la paginacion es de  en 15
	    return view('welcome',compact('posts'));

    }
}
