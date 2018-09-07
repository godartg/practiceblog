<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PagesController extends Controller
{
    public function home()
    {
    	$posts = Post::published()->paginate(); //por de fececto la paginacion es de  en 15
	    return view('pages.home',compact('posts'));

    }

    public function about()
    {
    	return view('pages.about');
    }

    public function archive()
    {
    	return view('pages.archive');
    }

    public function contact()
    {
    	return view('pages.contact');
    }
}
