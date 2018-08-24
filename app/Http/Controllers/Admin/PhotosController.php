<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{
    public function store(Post $post)
    {
    	$this->validate(request(),[
    		'photo' => 'required|image|max:2048'
    	]);
    	$photo = request()->file('photo');
    }
}

/* jpeg, png, bmp, gif, o svg, el maximo en kilobytes, tambien se pueden validar dimensioes con: 

dimensions:min_width=500,max_width=1500,min_height=100,

*/