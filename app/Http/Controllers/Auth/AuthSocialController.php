<?php
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Foundation\Auth\RegistersUsers;

use Redirect;
use Socialite;
use Auth;
use Exception;
use Illuminate\Http\Request;
//use Request;
// use App\User;
class AuthSocialController extends Controller
{

	// use ThrottlesLogins;
    //use AuthenticatesUsers;

    protected $redirectTo = '/';

	/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
    	// dd("test");
        //die;
        $service = ''; $this->redirectTo = '/';
        if ($request->route()->named('google')) {
            $service = 'google';
        }
        if ($request->route()->named('facebook')) {
            $service = 'facebook';
        }
        if ($request->route()->named('twitter')) {
            $service = 'twitter';
        }
        if(!empty($service)){
            return Socialite::driver($service)->redirect();
        }

        return redirect($this->redirectTo);
    }

    /**
     * Obtain the user information from Google,Twitter,Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    // public function handleProviderCallback(Request $request)
    // {
    //     $service = $user_signup_method = $socialid = '';
    //     if ($request->route()->named('google')) {
    //         $service = 'google'; $user_signup_method = 'GP'; $socialid = 'gp_id';
    //     }
    //     if($request->route()->named('facebook')) {
    //         $service = 'facebook'; $user_signup_method = 'FB'; $socialid = 'fb_id';
    //     }
    //     if($request->route()->named('twitter')) {
    //         $service = 'twitter'; $user_signup_method = 'TW'; $socialid = 'tw_id';
    //     }
    //     try {
    //         if(!empty($service)){
    //             $socialuser = Socialite::driver($service)->user();
    //             //dd($socialuser);
    //             $postedData = [
    //                 'user_id'=>$socialuser->id,
    //                 'name'=>$socialuser->name,
    //                 'email'=>$socialuser->email,
    //                 'user_signup_method'=>$user_signup_method,
    //                 'is_social_user'=>true,
    //                 'password'=>'',
    //                 $socialid => $socialuser->id
    //             ];
    //             if($request->session()->has('utm_source')){
    //                 $campaingsource = $request->session()->get('utm_source')."-".$request->session()->get('utm_campaign')."-".$request->session()->get('utm_medium');
    //                 $postedData['source'] = $campaingsource;
    //             }
    //             $epicwebArr = CurlAPI("users/signup",'POST',$postedData);
    //             //pr($postedData);die;
    //             if($epicwebArr['success']==true && isset($epicwebArr['session_id']) && !empty($epicwebArr['user_data'])){
    //                 $userdata = $epicwebArr['user_data'];
    //                 $message = $epicwebArr['message'];
    //                 $user = new User();
    //                 $user->id = $userdata['_id'];
    //                 // $user->ga_user_id = $epicwebArr['ga_user_id'];
    //                 foreach($userdata as $k=>$v){
    //                     $user->$k = $v;    
    //                 }
    //                 //Auth::login($user);
    //                 $trakcingData = ['Name'=>$userdata['name'],'Identity'=>$userdata['user_id'],'Email'=>$userdata['user_id'],'MSG-email'=>true,'MSG-push'=>true];
    //                 $request->session()->put('logintracking', $trakcingData);
    //                 $request->session()->put('logintrackingType', $request->post('authrequest'));
    //                 $user->api_session_id = $epicwebArr['session_id'];
    //                 $request->session()->put('authenticated', time());
    //                 $request->session()->put('api_session',$epicwebArr['session_id']);
    //                 $request->session()->put('user', $user);

    //                 // QRProtions
    //                 if($request->session()->has('promotionkey') && !empty($request->session()->get('promotionkey'))){
    //                     $container = app(); 
    //                     $request->request->add(['selectedsubscription' => 'epic_in_pl_2','promotionsselected'=>$request->session()->get('promotionkey')]);
    //                     return $container->call('App\Http\Controllers\UserAccountController@setSubscription');
    //                 } else if($request->session()->has('qrpromocodekey') && !empty($request->session()->get('qrpromocodekey'))){
    //                     $postedData = ['user_id'=>$userdata['user_id'],'session_id'=>$epicwebArr['session_id'],'coupon_code'=>$request->session()->get('qrpromocodekey')];
    //                     $container = app();
    //                     $epicwebArrpromo = CurlAPI("subscriptions/createcouponorder",'POST',$postedData);
    //                     $request->session()->forget('qrpromocodekey');
    //                     if($epicwebArrpromo['success']==true && !empty($epicwebArrpromo['subscription_data'])){
    //                         return $container->call('App\Http\Controllers\UserAccountController@qrpromocodesuccessfullack',['message'=>"QR Signup"]);
    //                     } else if($epicwebArrpromo['success']==false){
    //                         return $container->call('App\Http\Controllers\UserAccountController@qrpromocodefailureack',['message'=>$epicwebArrpromo['message']]); 
    //                     }
    //                 }

    //                 return redirect("/");
    //             } else {
    //                 return redirect("/login")->with(['message'=>$epicwebArr['message']]);
    //             }
    //         } 
    //         return redirect($this->redirectTo);
    //     } catch (Exception $e) {
    //         return redirect($this->redirectTo);
    //     }
    // }

}
?>