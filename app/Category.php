<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Category extends Model
{
    
    function Posts(){
    	return $this->HasMany(Post::class);
    }

}
