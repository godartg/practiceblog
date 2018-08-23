<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    // protected $fillable = ['title','excerpt','body','category'];
    protected $guarded = [];
    protected $dates = ['published_at']; // published_at es instancia de carbon
    
    public function getRouteKeyName()
    {
        // Retornamos el nombre del campo por el que queremos encontrar la url
        return 'url';
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }
    
    public function tags(){
    	return $this->belongsToMany(Tag::class);
    }

    public function scopePublished($query)
    {
    		$query->whereNotNull('published_at')
	    	->where('published_at','<=', Carbon::now() )
	    	->latest('published_at');
    }

}
