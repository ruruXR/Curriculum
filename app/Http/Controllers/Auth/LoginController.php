<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Storage;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function redirectToTwitterProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }
    
    public function handleTwitterProviderCallback()
    {
        //Twitterから情報を受け取る
        try {
            $user = Socialite::with("twitter")->user();
        } 
        catch (\Exception $e) {
            return redirect('/login');
        }
        
        //画像を大きいサイズに変更
        $image = str_replace("_normal.", ".", $user->getAvatar());
        
        //ユーザー作成
        $myinfo = User::Create([
            'token' => $user->token,
            'name' => $user->name,
            'image_path' => $image,
            'description' => $user->user['description'],
            ]);
        Auth::login($myinfo);
        return redirect()->to('/');
    
    }
}
