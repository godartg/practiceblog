<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    
    protected $fillable = [
        'post_id', 'url', 
    ];
    protected static function boot()
    {
        parent::boot();
        
    	static::deleting(function($photo){
            //
            $photo->detach();
            $photo->each->delete();
    	});
    }
    public function owner()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
}
