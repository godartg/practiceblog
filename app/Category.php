<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Category extends Model
{
    
    protected $guarded = [];

    function Posts(){
    	return $this->HasMany(Post::class);
    }

    public function getRouteKeyName()
    {
        // model bidding Retornamos el nombre del campo por el que queremos encontrar la url 
        return 'url';
    }
// un mutador cambia el lugar de get a set se ejecuta antes de gaurdar o actualizar el modelo
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['url'] = str_slug($name);
    }

// es un accesor cuando le agregamos getNameAttubute, donde name es el campo a modificar
//     public function getNameAttribute($name)
//     {
//         return str_slug($name);
//     }

    // public function posts()
    // {
    // 	return $this->hasMany(Post::class);
    // }

}
