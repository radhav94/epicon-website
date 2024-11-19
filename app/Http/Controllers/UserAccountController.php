<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class UserAccountController extends Controller
{
    public function addprofile()
    {
        // dd("true");
        // $params = [
        //     'slug' => 'home-v2',
        //     'list_language' => 'ALL',
        //     'display_language' => 'ENGLISH',
        //     'page' => 1,
        //     'tray_limit' => 5,
        // ];

        // $result = CurlAPI("pages/homepage", "GET", $params);
        // // dd($result['data']['list']['0']);
        // // dd($result);
        // if($result && @$result['success'] ==  true){

        //     $displayLanguageParam = setLanguageParameter();

        //     // dd($result);
            return view('epicon.add-profile');

        // }
        
    }

    public function manageprofile()
    {
        return view('epicon.manage-profile');
    }

    public function editprofile(){
        return view('epicon.edit-profile');
    }

    public function myaccount(){
 
        $hasFuture = false;
        $subscriptionPurchases=[];
        $subscriptionPurchasesArr = CurlAPI("users/purchases", 'POST', [] , 2, true, true);

        if(isset($subscriptionPurchasesArr) && @$subscriptionPurchasesArr['success'] == true){

            foreach(@$subscriptionPurchasesArr['data'] as $key=>$val){
                if (@$val['plan_status'] == 'future') {
                    $hasFuture = true;
                }
                if( @$val['plan_status'] == 'current' || (@$val['plan_status'] == 'past' && $key == 0 ) )
                {
                    $subscriptionPurchases = [
                        'user_id'=> @$val['user_id'],
                        'order_id'=> @$val['order_id'],
                        'plan_id'=> @$val['plan_id'],
                        'plan_name'=> @$val['plan_name'],
                        'plan_amount'=> @$val['plan_amount'],
                        'subscription_start_date'=> @$val['subscription_start_date'],
                        'subscription_end_date'=> @$val['subscription_end_date'],
                        'plan_status'=> @$val['plan_status'],
                        'device'=> @$val['device'],
                        'currency'=> @$val['currency'],
                        'validity_days'=> @$val['validity_days'],
                    ];
                    break;
                }
            }  
        }

        $viewprofile = CurlAPI("users/viewProfile", 'POST', [] , 2, true, true);  
        
        if(isset($viewprofile) && @$viewprofile['success'] == true){
            $viewprofile = @$viewprofile['user_data'];
        }else{
            $viewprofile = [];
        }

        return view('my-account.my-account', compact('subscriptionPurchases','viewprofile', 'hasFuture'));
    }

    public function TransactionHistory(){

        $subscriptionPurchases = CurlAPI("users/purchases", 'POST', [] , 2, true, true);

        if(isset($subscriptionPurchases) && @$subscriptionPurchases['success'] == true){
            $subscriptionPurchases = @$subscriptionPurchases['data'];
        }else{
            $subscriptionPurchases = [];
        }

        return view('my-account.transaction-history', compact('subscriptionPurchases'));
    }

    public function upgradePlan()
    {
        $data = ['auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
        $result = CurlAPI("subscriptions/upgradePlan", 'GET', $data, 2, true, true);
        if ($result && $result['success']) {
            $plandata = [];
            foreach (@$result['plans'] as $val) {
                if(isset($val['id'])){
                    $plandata[$val['id']] = [
                        'id' => $val['id'],
                        'name' => @$val['name'],
                        'plan' => @$val['plan'],
                        'actual_price' => @$val['actual_price'],
                        'currency' => @$val['currency'],
                        'epic_price' => @$val['actual_price'],
                        'save' => '',
                    ];
                }
            }
            if (count($plandata) > 0) {
                session()->put('plandata', $plandata);
            }
            return view('subscription.upgrade-plan', compact('result'));
        } else {
            return response()->view('pages.error.404', [], 404);
        }
    }
}
