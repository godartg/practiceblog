<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    // protected $fillable = ['title','excerpt','body','category'];
    // protected $guarded = [];

    protected $fillable = [
        'title', 'body', 'iframe', 'excerpt', 'published_at', 'category_id', 
    ];

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

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function scopePublished($query)
    {
    		$query->whereNotNull('published_at')
	    	->where('published_at','<=', Carbon::now() )
	    	->latest('published_at');
    }
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['url'] = str_slug($title);
    }

    public function setPublishedAtAttribute($published_at)
    {
        $this->attributes['published_at'] = $published_at ? Carbon::parse($published_at): null;
    }

    public function setCategoryIdAttribute($category)
    {
        $this->attributes['category_id'] = Category::find($category) 
                            ? $category 
                            : Category::create(['name' => $category])->id;
    }

    public function syncTags($tags)
    {
        $tagIds = collect($tags)->map(function($tag){
            return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        });

        return $this->tags()->sync($tagIds);
    }
}
