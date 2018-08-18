<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['title','excerpt','body','published_at','category'];
    protected $dates = ['published_at']; // published_at es instancia de carbon
    
    public function category(){
    	return $this->belongsTo(Category::class);
    }
    
    public function tags(){
    	return $this->belongsToMany(Tag::class);
    }

}
