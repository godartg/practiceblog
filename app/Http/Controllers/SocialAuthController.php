<?php

namespace App\Http\Controllers;

use App\User;
use Spatie\Permission\Models\Role;
use App\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SocialAuthController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    
    
    public function redirectToGoogleProvider(){
        $parameters = ['access_type' => 'offline'];
        return Socialite::driver('google')->scopes(["https://www.googleapis.com/auth/drive"])
                                        ->with($parameters)
                                        ->redirect();
    }
    public function handleProviderGoogleCallback(){
        $adminRole = [ 'name' => 'Admin' ];
        $socialUser = Socialite::driver('google')->stateless()->user();
        
        if(!Auth::check()){

            $user = User::updateOrCreate(['email'=>$socialUser->email],
                                        ['refresh_token'=>  $socialUser->token,
                                        'provider_id' => $socialUser->getId()]);
            
            $user->assignRole($adminRole);
            Auth::Login($user, true);
        }else{
            $user = User::find(Auth::user()->id);
            if($user->email!=$socialUser->email){
                $user->email= $socialUser->email;
            }
            $user->refresh_token = $socialUser->token;
            $user->provider_id = $socialUser->getId();
            $user->save();
        }
        return redirect()->to($this->redirectTo);
        
    }

}
