<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{
    public function store(Post $post)
    {
    	$this->validate(request(),[
    		'photo' => 'required|image|max:2048'
    	]);

    	// $photo = request()->file('photo')->store('posts','public');

    	// $photoUrl = Storage::url($photo);

        $post->photos()->create([
    		'url' => request()->file('photo')->store('posts','public'),
        ]);

     //    Photo::create([
     //        'url' => request()->file('photo')->store('posts','public'),
    	// 	'post_id' => $post->id,
    	// ]);


    }

    public function destroy(Photo $photo)
    {
        $photo->delete();

        return back()->with('flash','Foto eliminada');
        
        // $photoPath = str_replace('storage', 'public', $photo->url); // reemplazo de palabras

        // Storage::disk('public')->delete($photo->url);

    }
}

/* jpeg, png, bmp, gif, o svg, el maximo en kilobytes, tambien se pueden validar dimensioes con: 
dimensions:min_width=500,max_width=1500,min_height=100,laravel convierte a $photo = request()->file('photo') en una instancia de la clase Uploatedfile para luego usar el metodo storage que guarda el archivo en la carpeta storage

*/