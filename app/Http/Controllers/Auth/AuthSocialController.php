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
                $posted_data = [
                    'user_signup_method' => $user_signup_method,
                    $social_id => $social_user->id
                ];

                // $posted_data = [
                //     'user_id'=>$social_user->id,
                //     'name'=>$social_user->name,
                //     'email'=>$social_user->email,
                //     'user_signup_method'=>$user_signup_method,
                //     'is_social_user'=>true,
                //     'password'=>'',
                //     $social_id => $social_user->id
                // ];

                // if($request->session()->has('utm_source')){
                //     $campaingsource = $request->session()->get('utm_source')."-".$request->session()->get('utm_campaign')."-".$request->session()->get('utm_medium');
                //     $posted_data['source'] = $campaingsource;
                // }
                // dd($posted_data);
                $epic_web_arr = CurlAPI('users/socialLogin', 'POST', $posted_data, 2);
                // dd($epic_web_arr);die;

                if ($epic_web_arr['success'] == true && !empty($epic_web_arr['user_data'])) {
                    $user_data = $epic_web_arr['user_data'];
                    $message = $epic_web_arr['message'];
                    $user = new User();
                    $user->id = $user_data['_id'];
                    
                    foreach ($user_data as $k => $v) {
                        $user->$k = $v;
                    }

                    //Auth::login($user);
                    $tracking_data = ['Name' => $user_data['name'], 'Identity' => $user_data['user_id'], 'Email' => $user_data['user_id'], 'MSG-email' => true, 'MSG-push' => true];
                    $request->session()->put('logintracking', $tracking_data);
                    $request->session()->put('logintrackingType', $request->post('authrequest'));
                    $user->api_session_id = $epic_web_arr['session_id'] ?? null;
                    $request->session()->put('authenticated', time());
                    $request->session()->put('api_session', $epic_web_arr['session_id'] ?? null);
                    $request->session()->put('user', $user);
                    
                    // QRProtions
                    // if($request->session()->has('promotionkey') && !empty($request->session()->get('promotionkey'))){
                    //     $container = app(); 
                    //     $request->request->add(['selectedsubscription' => 'epic_in_pl_2','promotionsselected'=>$request->session()->get('promotionkey')]);
                    //     return $container->call('App\Http\Controllers\UserAccountController@setSubscription');
                    // } else if($request->session()->has('qrpromocodekey') && !empty($request->session()->get('qrpromocodekey'))){
                    //     $posted_data = ['user_id'=>$user_data['user_id'],'session_id'=>$epic_web_arr['session_id'],'coupon_code'=>$request->session()->get('qrpromocodekey')];
                    //     $container = app();
                    //     $epic_web_arrpromo = CurlAPI("subscriptions/createcouponorder",'POST',$posted_data);
                    //     $request->session()->forget('qrpromocodekey');
                    //     if($epic_web_arrpromo['success']==true && !empty($epic_web_arrpromo['subscription_data'])){
                    //         return $container->call('App\Http\Controllers\UserAccountController@qrpromocodesuccessfullack',['message'=>"QR Signup"]);
                    //     } else if($epic_web_arrpromo['success']==false){
                    //         return $container->call('App\Http\Controllers\UserAccountController@qrpromocodefailureack',['message'=>$epic_web_arrpromo['message']]); 
                    //     }
                    // }

                    return redirect("/");
                } else {
                    return redirect("/login")->with(['message' => $epic_web_arr['message']]);
                }
            }
            return redirect($this->redirectTo);
        } catch (Exception $e) {
            return redirect($this->redirectTo);
        }
    }

}
?>