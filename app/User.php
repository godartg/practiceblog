<?php

namespace App;

use App\Post;
use App\SocialNetwork;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider_id', 'refresh_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function socialNetwork(){
        return $this->hasMany(SocialNetwork::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeAllowed($query)
    {
        //view es nombre de la funcion en UserPolicy y $this es usuario actual
        if ( auth()->user()->can('view',$this ) ) 
        {
            return $query;
        }
        
        return $query->where('id',auth()->id());
    }
}
