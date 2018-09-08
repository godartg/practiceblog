<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    // protected $fillable = ['title','excerpt','body','category'];
    // protected $guarded = [];

    protected $fillable = [
        'title', 'body', 'iframe', 'excerpt', 'published_at', 'category_id', 'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($post){
            $post->tags()->detach();
            $post->photos->each->delete();
        });
    }

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

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopePublished($query)
    {
    		$query->whereNotNull('published_at')
	    	->where('published_at','<=', Carbon::now() )
	    	->latest('published_at');
    }

    public function scopeAllowed($query)
    {
        if ( auth()->user()->hasRole('Admin') ) 
        {
            return $query;
        }
        else
        {
            return $query->where('user_id',auth()->id());
        }
    }

    public function isPublished()
    {
        return ! is_null($this->published_at) && $this->published_at < today() ;
    }

    static function create(array $attributes = [])
    {
        $attributes['user_id'] = auth()->id();
        $post = static::query()->create($attributes);
        $post->generateUrl();

        return $post;
    }

    public function generateUrl()
    {
        $url = str_slug($this->title);
        if ($this->whereUrl($url)->exists()) 
        {
            $url = "{$url}-{$this->id}";
        }
        $this->url = $url;
        $this->save();
    }
    // public function setTitleAttribute($title)
    // {
    //     $this->attributes['title'] = $title;

    //     $url = str_slug($title);
    //     $duplicateUrlCount = Post::where('url','LIKE',"{$url}%")->count();
    //     if ($duplicateUrlCount) 
    //     {
    //         $url .="-". ++$duplicateUrlCount;
    //     }

    //     $this->attributes['url'] = $url;
    // }

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

    public function viewType($home = '')
    {
        if ($this->photos->count() === 1):
            return 'posts.photo';
        elseif($this->photos->count() > 1):
            return $home === 'home' ? 'posts.carousel-preview': 'posts.carousel';
        elseif($this->iframe):
            return 'posts.iframe';
        else: 
            return 'posts.text';
        endif;
    }
}
