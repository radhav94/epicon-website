@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

    <!-- coupon modal start -->

    <div class="modal fade coupon-model" id="redeem-popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity: 1;">
        <div class="modal-dialog modal-lg modal-dialog-centered px-3">
            <div class="modal-content">
                <div class="modal-body coupon-model-body text-center py-5">
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="text-white mt-4">Congratulations!</h4>
                    <p class="w-75 text-white medium m-auto mb-4">You've successfully redeemed offer</p>
                    <div class="coupon-code">
                        <h6 class="code small">Coupon Code</h6>
                        <p class="redeem-code">F E M C L K 10</p>
                    </div>
                    <p class="w-50 text-white small m-auto mb-4 mt-4">Your coupon is saved in your summary</p>
    
                </div>
            </div>
        </div>
    </div>

    <!-- coupon modal end -->

    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h4 class="text-white pb-3">My Rewards</h4>
            </div>
            <div class="col-sm-12">
                <div class="my-reward">
                    <ul class="p-0 m-0 list-unstyled">
                        <li>
                            <div class="coin-balance">
                                <p>EpicOn Coin Balance</p>
                                <h1>{{$walletArr['epicoinData']['epicoins']}}<img src="{{ asset('/img/coin.svg') }}" alt="coin"></h1>
                            </div>
                            <img class="my-reward-gift" src="{{ asset('/img/my-reward-gift.svg') }}" alt="">
                        </li>
                        <li>
                            <div class="coin-balance">
                                <p class="small">Total EpicOn<br>Coins Claimed</p>
                                <h1>{{$walletArr['epicoinData']['debited']}}</h1>
                            </div>
                            <img class="my-reward-gift" src="{{ asset('/img/my-reward-coin.svg') }}" alt="">
                        </li>
                        <li>
                            <div class="coin-balance">
                                <p class="small">Total EpicOn<br>Coins Earned</p>
                                <h1>{{$walletArr['epicoinData']['credited']}}</h1>
                            </div>
                            <img class="my-reward-gift" src="{{ asset('/img/my-reward-coin.svg') }}" alt="">
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="w-100 library">
                    <ul class="nav nav-pills border-bot pb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-list" data-bs-toggle="pill" data-bs-target="#pills-earn" type="button" role="tab" aria-controls="pills-earn" aria-selected="true">Earn</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-redeem" type="button" role="tab" aria-controls="pills-redeem" aria-selected="false">Redeem</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab" aria-controls="pills-summary" aria-selected="false">Summary</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-earn" role="tabpanel" aria-labelledby="my-list">
                            <ul class="earn list-unstyled p-0 mb-0 mt-4">
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">1 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin-10.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">10 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin-50.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">50 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin-150.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">150 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin-300.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">300 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                                <li>
                                    <img class="mt-5" src="{{ asset('/img/coin-600.svg') }}" alt="coin">
                                    <h5 class="my-4 text-white">600 EpicOn Coins</h5>
                                    <span class="earn-bottom">
                                        Engage & Earn <br>for 20 min
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-redeem" role="tabpanel" aria-labelledby="my-list">
                            <ul class="redeem list-unstyled p-0 mb-0 mt-4">
                               <?php foreach ($walletArr['redeem'] as $offercontent) { 
                                $vendor_image = isset($offercontent['vendor_image']) ? $offercontent['vendor_image'] : '';
                                $offer_image = isset($offercontent['offer_image']) ? $offercontent['offer_image'] : $vendor_image;
                               $todaydate = date("Y-m-d");
                               $expiry_date = date('Y-m-d', strtotime($offercontent['offer_expiry_date']));
                               $todaydate = new DateTime($todaydate);
                               $expiry_date = new DateTime($expiry_date);
                               $interval = $todaydate->diff($expiry_date);
                               $expiry_days = $interval->days;
                                 ?>
                                <li>
                                    <div class="redeem-top Redeembtn">
                                        <input type="hidden" name="redeem_coupon" id="redeem_coupon" value="{{$offercontent['coupon_code']}}">
                                        <div class="logo-coin">
                                            <img src="{{ $offer_image }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">{{$offercontent['epicoins']}}</h4>
                                        </div>
                                        <p class="mt-4">{{$offercontent['offer_title']}}</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>&nbsp;{{$expiry_days}} Days</span>
                                    </div>
                                </li>
                                <?php } ?>
                               <!--  <li>
                                    <div class="redeem-top">
                                        <div class="logo-coin">
                                            <img src="{{ asset('/img/McD.svg') }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">350</h4>
                                        </div>
                                        <p class="mt-4">Buy 1 Get 1 Free on Happy Meal on MacD</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>1 Day</span>
                                    </div>
                                </li> -->
                                <!-- <li>
                                    <div class="redeem-top">
                                        <div class="logo-coin">
                                            <img src="{{ asset('/img/McD.svg') }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">350</h4>
                                        </div>
                                        <p class="mt-4">Buy 1 Get 1 Free on Happy Meal on MacD</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>1 Day</span>
                                    </div>
                                </li> -->
                                <li>
                                    <div class="redeem-top">
                                        <div class="logo-coin">
                                            <img src="{{ asset('/img/McD.svg') }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">350</h4>
                                        </div>
                                        <p class="mt-4">Buy 1 Get 1 Free on Happy Meal on MacD</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>1 Day</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="redeem-top">
                                        <div class="logo-coin">
                                            <img src="{{ asset('/img/McD.svg') }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">350</h4>
                                        </div>
                                        <p class="mt-4">Buy 1 Get 1 Free on Happy Meal on MacD</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>1 Day</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="redeem-top">
                                        <div class="logo-coin">
                                            <img src="{{ asset('/img/McD.svg') }}" alt="logo">
                                            <h4><img src="{{ asset('/img/coin.svg') }}" alt="">350</h4>
                                        </div>
                                        <p class="mt-4">Buy 1 Get 1 Free on Happy Meal on MacD</p>
                                    </div>
                                    <div class="redeem-bottom">
                                        Expires in<span>1 Day</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-summary" role="tabpanel" aria-labelledby="my-list">
            
                            <div class="trasaction-table table-responsive w-100">
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($walletArr['summary'] as $offersummary) {
                                            $offer_image = isset($offersummary['offer_image']) ? $offersummary['offer_image'] : $offersummary['vendor_image'];
                                            $redeemOn = isset($offersummary['redeem_on']) && !empty($offersummary['redeem_on']) ? date('d F Y', strtotime($offersummary['redeem_on'])) : '';
                                        ?>
                                        <tr>
                                            <td><img class="summary-img" src="{{ $offer_image }}" alt="logo">Audible {{$offersummary['offer_title']}}</td>
                                            <td style="color:#B7B7B7">Claimed on {{$redeemOn}}</td>
                                            <td class="text-end"><img width="15" src="{{ asset('/img/coin.svg') }}" alt="">&nbsp; {{$offersummary['epicoins']}}</td>
                                        </tr>
                                        <?php } ?>
                                    <!-- <tr>
                                        <td><img class="summary-img" src="{{ asset('/img/macd-img.png') }}" alt="logo">Buy 1 Get 1 Free on Happy Meal on MacD</td>
                                        <td style="color:#B7B7B7">Claimed on 03/08/2023</td>
                                        <td class="text-end"><img width="15" src="{{ asset('/img/coin.svg') }}" alt="">&nbsp; 499</td>
                                    </tr>
                                    <tr>
                                        <td><img class="summary-img" src="{{ asset('/img/macd-img.png') }}" alt="logo">Free Starbucks Caramel Frappucino Large</td>
                                        <td style="color:#B7B7B7">Claimed on 03/08/2023</td>
                                        <td class="text-end"><img width="15" src="{{ asset('/img/coin.svg') }}" alt="">&nbsp; 499</td>
                                    </tr>
                                    <tr>
                                        <td><img class="summary-img" src="{{ asset('/img/macd-img.png') }}" alt="logo">Audible Subscription for 3 months</td>
                                        <td style="color:#B7B7B7">Claimed on 03/08/2023</td>
                                        <td class="text-end"><img width="15" src="{{ asset('/img/coin.svg') }}" alt="">&nbsp; 499</td>
                                    </tr> -->
                                    </tbody>
                                </table>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


@stop

@section('script')
  <script>
    $(document).ready(function() {
       $("#redeem-popup").hide();
      $(".Redeembtn").click(function(e) {
            e.preventDefault();
            // alert("clicked on redeem");
            
            var formData = $('#redeem_coupon').val();
            $('.redeem-code').html(formData);
            var requestData = {
                coupon_code: formData
            };
            $.ajax({
                url: '{{ route('redeemcoupon') }}',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log("on success");
                    if(response.payload.success == true){
                        $("#redeem-popup").show();
                        setTimeout(function() {
                            location.reload();
                        }, 5000); // Refresh every 5000 milliseconds (5 seconds)
                    }else{
                        showToaster(response.payload.response.message, 2);
                      // console.log("on fail");  
                    }
                    
                },
                error: function(xhr, status, error) {}
            });
        });

      $(".btn-close").click(function() {
            $('#redeem-popup').hide();
        });

  });
  </script>
@stop