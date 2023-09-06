@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

    
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
                                <h1>143<img src="{{ asset('/img/coin.svg') }}" alt="coin"></h1>
                            </div>
                            <img class="my-reward-gift" src="{{ asset('/img/my-reward-gift.svg') }}" alt="">
                        </li>
                        <li>
                            <div class="coin-balance">
                                <p class="small">Total EpicOn<br>Coins Claimed</p>
                                <h1>143</h1>
                            </div>
                            <img class="my-reward-gift" src="{{ asset('/img/my-reward-coin.svg') }}" alt="">
                        </li>
                        <li>
                            <div class="coin-balance">
                                <p class="small">Total EpicOn<br>Coins Claimed</p>
                                <h1>143</h1>
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
                                        <tr>
                                            <td><img class="summary-img" src="{{ asset('/img/macd-img.png') }}" alt="logo">Audible Subscription for 3 months</td>
                                            <td style="color:#B7B7B7">Claimed on 03/08/2023</td>
                                            <td class="text-end"><img width="15" src="{{ asset('/img/coin.svg') }}" alt="">&nbsp; 499</td>
                                        </tr>
                                    <tr>
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
                                    </tr>
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
  
@stop