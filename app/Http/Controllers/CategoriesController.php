<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoriesController extends Controller
{
    public function show(Category $category)
    {
    	// return $category->load('posts');
    	// $posts =  $category->posts;
    	// return view('welcome',compact('posts'));
    	return view('welcome',[
    		'title' => "Publicaciones de la categoria: $category->name ",
    		'posts' => $category->posts()->paginate(),
    	]);
    }
}
