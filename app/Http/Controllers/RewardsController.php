<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    public function MyRewards(Request $request){

        $walletArr = CurlAPI("rewards/rewardsInfo", 'POST', '' , 2, true, true);
            // dd($walletArr);
        if($walletArr && @$walletArr['success'] == true){
            $walletArr = @$walletArr['data'];
            return view('rewards.my-reward',compact('walletArr'));
        }else{
            \Log::channel('error_404')->debug('--------------(rewards/rewardsInfo) Error ('.time().')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($walletArr));
            return response()->view('pages.error.404', [], 404);
        }
    }

    public function RedeemCouponCode(Request $request){
       $coupon_code = $request->post('coupon_code'); 

       $SendCouponRequestData = array(
                'offer_coupon_code' => $coupon_code,
            );
       $redeemApi = CurlAPI("rewards/epicoinsOffersRedeem",'POST',$SendCouponRequestData,2, true, true);
       $response['message'] = @$redeemApi['message'];
       if ($redeemApi && @$redeemApi['success'] == true) {
                return JSONResponse(200, 'Offer redeemed successfully.', ['response' => $response, 'success' => true]);
            } else {
                return JSONResponse(200, 'Coupon Redeem Failed', ['response' => $response, 'success' => false]);
            }
    }
}
