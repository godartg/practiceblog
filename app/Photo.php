<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    
    protected $fillable = [
        'post_id', 'file_id', 
    ];
    
    public function owner()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
}
