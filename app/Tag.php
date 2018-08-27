<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // public function posts(){
    // 	return $this->hasMany(Post::class);
    // }

    protected $guarded = [];

    public function getRouteKeyName()
    {
    	return 'url';
    }

    public function posts()
    {
    	return $this->belongsToMany(Post::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['url'] = str_slug($name);
    }
}
