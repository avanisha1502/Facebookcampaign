<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

<<<<<<< HEAD
    public function redirectToFacebook()
    {
        // $facebookClientId = config('services.facebook.client_id');
        // dd($facebookClientId , env('FACEBOOK_APP_ID'));
        return Socialite::driver('facebook')->redirect();
    }

=======
>>>>>>> 16cb19a4160dbd4f26485253e1f831e96e9246e9

    public function handleGoogleCallback()
    {
        try {
        
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
         
            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->intended('/home');
         
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'google_id'=> $user->id,
                        'password' => encrypt($user->email)
                    ]);
         
                Auth::login($newUser);
        
                return redirect()->intended('/home');
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

<<<<<<< HEAD
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/home');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'facebook_id' => $user->id,
                    'password' => encrypt($user->email)
                ]);

                Auth::login($newUser);
                return redirect()->intended('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

=======
>>>>>>> 16cb19a4160dbd4f26485253e1f831e96e9246e9
    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect to login page after logout
    }
}
