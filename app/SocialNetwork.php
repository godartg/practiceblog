<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $fillable = [
        'user_id', 'email', 'provider_id', 'refresh_token',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($post){
            $post->tags()->detach();
            $post->photos->each->delete();
        });
    }
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
