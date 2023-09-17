<?php
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Foundation\Auth\RegistersUsers;

// use Redirect;
use Socialite;
// use Auth;
use Exception;
use Illuminate\Http\Request;

//use Request;
use App\Models\User;
class AuthSocialController extends Controller
{

    // use ThrottlesLogins;
    //use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request)
    {
        // dd("test");
        // die;
        $service = '';
        $this->redirectTo = '/';

        if ($request->route()->named('login.google')) {
            $service = 'google';
        }

        if ($request->route()->named('login.facebook')) {
            $service = 'facebook';
        }

        if ($request->route()->named('login.twitter')) {
            $service = 'twitter';
        }

        if (!empty($service)) {
            return Socialite::driver($service)->redirect();
        }

        return redirect($this->redirectTo);
    }

    /**
     * Obtain the user information from Google,Twitter,Facebook.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $service = $user_signup_method = $social_id = '';

        if ($request->route()->named('login.google.callback')) {
            $service = 'google';
            $user_signup_method = 'GP';
            $social_id = 'gp_id';
        }

        if ($request->route()->named('login.facebook.callback')) {
            $service = 'facebook';
            $user_signup_method = 'FB';
            $social_id = 'fb_id';
        }

        if ($request->route()->named('login.twitter.callback')) {
            $service = 'twitter';
            $user_signup_method = 'TW';
            $social_id = 'tw_id';
        }

        try {
            if (!empty($service)) {
                $social_user = Socialite::driver($service)->user();
                // dd($social_user);
                $user_id = $social_user->id ?? null;
                $user_data = [];
                $posted_data = [
                    'user_signup_method' => $user_signup_method,
                    $social_id => $user_id
                ];

                $epic_web_arr = CurlAPI('users/socialLogin', 'POST', $posted_data, 2);
                
                if(isset($epic_web_arr['user_data'])){
                    $user_data = $epic_web_arr['user_data'];
                }

                if ($epic_web_arr['success'] == true && !empty($user_data)) {
                    $request->session()->put('user_id', $user_id);
                    $request->session()->put('user', $user_data);
                    $request->session()->put('user_token', $epic_web_arr['token']);

                    return redirect("/");
                } else {
                    return redirect("/login/".$service)->with(['message' => $epic_web_arr['message']]);
                }
            }
            return redirect($this->redirectTo);
        } catch (Exception $e) {
            return redirect($this->redirectTo);
        }
    }

}
?>