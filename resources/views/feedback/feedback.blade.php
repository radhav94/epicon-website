@extends('layouts.default')
@section('title','Help & Feedback')
 

@section('content')

<section class="helps-feedback container w-100 my-4">
    <div class="row justify-content-center">

        <div class="col-sm-12 border-bot">
            <h4 class="text-white mb-4">{{__('Help & Feedback')}}</h4>
        </div>
        <div class="col-sm-12">
            <div class="w-100 mb-5 mt-4">
                <div class="search-header">
                    <div class="inside-head">
                        <img src="{{ asset('/img/search-white.png') }}" alt="">
                        <input type="text" id="search-feedback" name="search-feedback" placeholder="{{__('How can we help you today?')}}">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <h4 class="text-white mb-4">{{__('Frequently Asked Questions')}}</h4>
        </div>
        <div class="col-sm-12" id="noData-error" style="color:white; padding-top: 20px;display:none;">
                <p style="text-align:center">{{__('No Results Found')}}</p>
        </div>
        <div class="faq-accordian col-sm-12 mb-5">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item border-bot" id="accordion1">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            What is the NEW EPIC ON App version I should have in Android and IOS App?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body text-white">
                            <ul>
                                 <li>Android version- 3.0.0 and above</li>
                                 <li>IOS Version - 4.8 and above</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion2">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            On which platforms is the EPIC ON App available?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body text-white">
                            <ul>
                         <li>EPIC On app is currently available on Google Play Store and Apple Store. Click on the links below to download our app.</li>
                         - <a target="_blank" style="color:#fff" href="https://play.google.com/store/apps/details?id=com.epicchannel.epicon&amp;hl=en">Google Play Store </a><br>
                         - <a target="_blank" style="color:#fff" href="https://apps.apple.com/in/app/epic-on/id1252513341">Apple Store</a><br>

                         <li>Website</li>
                         Please visit the link below to access EPIC ON through a desktop.<br>
                         - <a target="_blank" style="color:#fff" href="https://www.epicon.in">https://www.epicon.in </a><br>

                         <li>TV App</li>
                         The all-new EPIC ON app will be on the below-mentioned platforms in a couple of months. While you wait, you can still enjoy the previous version of the EPIC ON app.<br>

                         - MI TV<br>
                         - Amazon Fire TV<br>
                         - Apple TV<br>
                         - Roku<br>
                         - Android TV<br>
                         - Cloud TV<br>
                         - TCL (Google Play Store)<br>
                         - One Plus (Google Play Store)<br>
                         - MI Box (Google Play Store)<br>



                     </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion3">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            How do I generate a TV PIN?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body text-white">
                            <ul>
                             - Open the EPIC On app<br>
                             - Tap on the menu bar<br>
                             - Select 'My Devices' and a 6 digit code will be generated<br>
                             - Launch the EPIC On app on your Smart TV<br>
                             - Select Login with PIN<br>
                             - Enter the 6-digit PIN displayed in the app on the Smart TV<br>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion4">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                            How do I contact the support team?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                        <div class="accordion-body text-white">
                        <ul>
                         - You can send in your queries by selecting the contact us option available on the website/ App or you can write to us at epicon@in10media.com
                        </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion5">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                            How do I apply a promo/voucher code ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>To use the voucher code on our app:</li>
                             - Download the EPIC On app through Google Play Store<br>
                             - Log in to your registered EPIC On account<br>
                             - Tap the menu bar<br>
                             - Click on the Subscription page<br>
                             - Enter the voucher code<br>
                             - Click on Submit<br>

                             <li>To use the voucher code on our website:</li>
                             - Log on to our EPIC On website<br>
                             - Log in to your registered EPIC On account<br>
                             - Access the Subscription page by clicking on your name displayed<br>
                             - Enter the voucher code<br>
                             - Click on Apply<br>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion6">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                            How can you watch content from the EPIC On app on multiple devices simultaneously using the same account?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>You will have to pause the content on the current device and click on play on the other device, after 10 seconds. The content will start playing on the second device.</li>
                             <li>You will be able to login to multiple devices only once you are a premium member. Subscribe Today!</li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion7">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSeven">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
                            What is EPIC On Premium Membership?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSeven">
                        <div class="accordion-body text-white">
                            <ul>
                                 -EPIC On premium membership allows you to gain access to all the content available along with Live TV, Podcasts, eBooks, Games and more

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion8">
                    <h2 class="accordion-header" id="panelsStayOpen-headingEight">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="false" aria-controls="panelsStayOpen-collapseEight">
                            How do I become a premium member?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingEight">
                        <div class="accordion-body text-white">
                            <ul>
                                 - Open the app<br>
                                 - Tap on the menu bar<br>
                                 - Go to 'Subscription Plans' to see a list of available plans<br>
                                 - Select the plan of your choice and hit 'Subscribe'<br>
                                 - Select a payment option and click on the 'Continue to Pay' button<br>
                                 - Enter the necessary details and proceed.<br>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion9">
                    <h2 class="accordion-header" id="panelsStayOpen-headingNine">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseNine" aria-expanded="false" aria-controls="panelsStayOpen-collapseNine">
                            Is EPIC On available outside India?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseNine" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingNine">
                        <div class="accordion-body text-white">
                            <ul>
                                 -Yes, EPIC On services are available outside India as well.
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion10">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTen" aria-expanded="false" aria-controls="panelsStayOpen-collapseTen">
                            In which languages is EPIC On available ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTen">
                        <div class="accordion-body text-white">
                            <ul>
                                 -English and Hindi on Website , Android App, IOS App
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion11">
                    <h2 class="accordion-header" id="panelsStayOpen-headingEleven">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEleven" aria-expanded="false" aria-controls="panelsStayOpen-collapseEleven">
                            How do I change my display/content language?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseEleven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingEleven">
                        <div class="accordion-body text-white">
                            <ul>
                                 -To change the language go to settings and select the desired display and content language.
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion12">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwelve">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwelve" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwelve">
                            What is My List on EPIC On?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwelve" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwelve">
                        <div class="accordion-body text-white">
                            <ul>
                                 -You can add your favorite content from Watch , Listen, Read
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion13">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirteen">
                            How do I create my  list ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirteen">
                        <div class="accordion-body text-white">
                            <ul>
                                 -You can select the content from watch, listen and read  of your choice and click on the 'Add to my list icon' displayed below the content.

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion14">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFourteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFourteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseFourteen">
                            How to access My List?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFourteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFourteen">
                        <div class="accordion-body text-white">
                            <ul>
                                 -To access content from your list you will have to tap on the menu bar and select My List
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion15">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFifteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFifteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseFifteen">
                            How do I cancel auto-renewal through Google Play Store?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFifteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFifteen">
                        <div class="accordion-body text-white">
                            <ul>
                             - On your Android phone or tablet, open the Google Play Store<br>
                             - Check if you’re signed in to the correct Google Account<br>
                             - Tap Menu<br>
                             - Select the subscription you want to cancel<br>
                             - Tap Cancel subscription<br>
                             - Follow instructions/guidelines<br>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion16">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSixteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSixteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseSixteen">
                            How do I cancel auto-renewal through Amazon in - app purchase ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseSixteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSixteen">
                        <div class="accordion-body text-white">
                            <ul>
                                 - Go to Amazon.com and login<br>
                                 - Tap on Account and Lists<br>
                                 - Go to the Subscription and Membership page<br>
                                 - Click on the Actions drop-down next to the subscription<br>
                                 - Select ‘Turn off auto-renewal’.<br>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion17">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSeventeen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeventeen" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeventeen">
                            What is the Renew Plan feature?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSeventeen">
                        <div class="accordion-body text-white">
                            <ul>
                             -You can subscribe to multiple plans with your current active plan.
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion18">
                    <h2 class="accordion-header" id="panelsStayOpen-headingEighteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEighteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseEighteen">
                            Can I use renew plan feature  If I am subscribed from Apple itune store and google play store
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseEighteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingEighteen">
                        <div class="accordion-body text-white">
                            <ul>
                                 -If you are subscribed to plans through Apple itune store and google play store renew plan feature will not be available
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion19">
                    <h2 class="accordion-header" id="panelsStayOpen-headingNineteen">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseNineteen" aria-expanded="false" aria-controls="panelsStayOpen-collapseNineteen">
                            Can I view downloaded content once my subscription ends?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseNineteen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingNineteen">
                        <div class="accordion-body text-white">
                            <ul>
                                 -You will be able to stream downloaded content only till your subscription is active.
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion20">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwenty">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwenty" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwenty">
                            How to enable subtitles?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwenty" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwenty">
                        <div class="accordion-body text-white">
                            <ul>
                                 - You can select the CC icon displayed on the screen to enable subtitles.
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion21">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentyone">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentyone" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentyone">
                            How do I review my payment history on EPIC On ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentyone" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentyone">
                        <div class="accordion-body text-white">
                            <ul>
                                 <li>To view your payment history please follow below steps.</li>
                                 <li>Click on the menu icon  > Subscription Plan > History</li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion22">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentytwo">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentytwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentytwo">
                            What is EPICOINS and Reward Store?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentytwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentytwo">
                        <div class="accordion-body text-white">
                            <ul>
                                 -Please click on the Reward Store section in the app and website to know more.
                                 -For more details please click on the FAQ <a href="https://www.epicon.in/epicoins-faq">(https://www.epicon.in/epicoins-faq)</a>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion23">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentythree">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentythree" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentythree">
                            How can you verify your EPIC On account?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentythree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentythree">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>Verification is only applicable for users who have registered/signed up via email ID or mobile number. Users signing up using social login do not need to verify their EPIC On account.</li>
                             <li>Users signing up using email ID, please follow the steps given below:
                             <ul>
                             <li>- Once you have registered on the EPIC On platform, check your email inbox (check your email Spam folder if you do not see an email in your inbox).</li>
                             <li>- Open the email received from EPIC On.</li>
                             <li>- Click on the verification link mentioned in the email.</li>
                             <li>- You have successfully verified your EPIC On account!</li>
                             <li>- Now you can visit the EPIC On app or website, and login using the registered email ID and password.</li></ul></li>
                             <li>Users signing up via mobile number, please follow the steps given below:</li>
                             <ul><li>- Once you have registered on the EPIC On platform, you will receive an SMS with an OTP on your registered mobile number.</li>
                             <li>- Enter the OTP on the EPIC On app or website.</li>
                             <li>- You have successfully verified your EPIC On account!</li>
                             <li>- Now you can visit the EPIC On app or website, and login using the registered mobile number and password.</li>
                             <ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion24">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentyfou">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentyfou" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentyfou">
                           How can you reset your EPIC On account password?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentyfou" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentyfou">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Click on Forgot Password link on the sign-in page.</p>
         </ul>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         If you have registered on the EPIC On platform using email ID,
         please provide the registered email ID. <!-- Is there a box? We need to specify where they need to provide the details --><!-- Yes --></p>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         - You will receive an email with a link to reset the password in your
         email inbox.</p>
         <li/>
         <p lang="en-IN" style="">
         - Click on the link, and enter the new password and re-enter it to
         confirm.</p>
         <li/>
         <p lang="en-IN" style="">
         - Click on Update.</p>
         <li/>
         <p lang="en-IN" style="">
         - You can now login to your EPIC On account using your registered
         email ID and the new password.</p>
         </ul>
         </ul>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         If you have registered on the EPIC On using mobile number, please
         provide the registered mobile number<!-- Is there a box? We need to specify where they need to provide the details --><!-- Yes -->.</p>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         - You will receive an SMS with a 6-digit OTP.</p>
         <li/>
         <p lang="en-IN" style="">
         - Visit the EPIC On app or website and enter the OTP, the new
         password and re-enter it to confirm. <!-- Where on the website? Will there be a link? --><!-- There will be a link on the website and the app. --></p>
         <li/>
         <p lang="en-IN" style="">
         - You can now login to your EPIC On account using your registered
         mobile number and the new password.</p>
         </ul>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion25">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentyfive">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentyfive" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentyfive">
                            How can you cancel your subscription on iOS?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentyfive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentyfive">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         If you have an iPhone/iPad, please follow the steps given below:</p>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         - Launch the Settings app.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on iTunes and the App Store.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on your Apple ID.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap View Apple ID when the pop up window appears.</p>
         <li/>
         <p lang="en-IN" style="">
         - Enter your Apple ID password, face ID, or fingerprint ID when
         prompted.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on Subscriptions.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on View Apple ID, then tap on Subscriptions.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on the Subscription you want to cancel.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on Cancel Subscription.</p>
         <li/>
         <p lang="en-IN" style="">
         - Tap on Confirm when prompted to confirm that you want to cancel
         your subscription.</p>
         <li/>
         <p lang="en-IN" style="">
         - After your current subscription period ends, iTunes will no longer
         bill you for your EPIC On subscription.</p>
         </ul>
         </ul>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         If you have a Mac, please follow the steps given below:</p>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         - Open iTunes on your Mac.</p>
         <li/>
         <p lang="en-IN" style="">
         - Go to the Store section of your Music Library.</p>
         <li/>
         <p lang="en-IN" style="">
         - Click on the Accounts link in the right column.</p>
         <li/>
         <p lang="en-IN" style="">
         - Sign in, if necessary.</p>
         <li/>
         <p lang="en-IN" style="">
         - Scroll down to the Settings header.
         </p>
         <li/>
         <p lang="en-IN" style="">
         - Click on Manage next to Subscriptions.</p>
         <li/>
         <p lang="en-IN" style="">
         - Find the subscription you wish to cancel and press Edit.</p>
         <li/>
         <p lang="en-IN" style="">
         - Press Cancel Subscription.</p>
         </ul>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion26">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentysix">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentysix" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentysix">
                            How can you access videos you have downloaded/offline videos?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentysix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentysix">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>
                             <p lang="en-IN" style="">
                                 Open the EPIC On app</p>
                             </li>
                             <li>
                             <p lang="en-IN" style="">
                                 Tap on the download icon of bottom bar</p>
                             </li>
                             <li>
                             <p lang="en-IN" style="">
                                 Downloaded content will be visible.</p>
                             </li>
                             <li>
                             <p lang="en-IN" style="">
                                 Click on the content you wish to view and start watching.</p>
                             </li>
                             <li>
                             <p><b>Note</b>: You need to be logged in (online or offline) to view
                             your downloads. Downloaded videos will be available on your device
                             for 7 days from the date of download.</p>
                             </li> 
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion27">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentyseven">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentyseven" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentyseven">
                            What are the modes of payment available to pay the subscription amount?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentyseven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentyseven">
                        <div class="accordion-body text-white">
                        <ul>
                             <li>If you are subscribing to EPIC On from India:</li>
                             -If you are an iOS user, you can only pay via iOS in App Purchases.<br>
                             -If you are an Android user, you can pay via Google in App Purchase or use credit card, debit card, net banking, wallets via PayU and amazonpay<br>
                             -If you are using our website, you can pay via credit card, debit card, net banking, wallets via PayU and amazonpay<br>

                             <li>If you are subscribing to EPIC On from any country apart from India:</li>
                             -If you are an iOS user, you can only pay via iOS in App Purchases.<br>
                             -If you are an Android user, you can pay via Google in App Purchase or credit card, debit card, net banking, and wallets via PayU.<br>
                             -If you are using our website, you pay via credit card, debit card, net banking, and wallets via PayU<br>

                         </ul>
                         <ul>
                         <li/>
                         <p lang="en-IN" style="">
                         If you are subscribing to EPIC On from any country apart from
                         India:</p>
                         <ul>
                         <li/>
                         <p lang="en-IN" style="">
                          - If you are an iOS user, you can only pay via iOS in App Purchases.</p>
                         <li/>
                         <p lang="en-IN" style="">
                         - If you are an Android user, you can pay via Google in App Purchase
                         or credit card, debit card, net banking, and wallets via CC avenue.</p>
                         <li/>
                         <p lang="en-IN" style="">
                         - If you are using our website, you pay via credit card, debit card,
                         net banking, and wallets via CC avenue.</p>
                         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion28">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentyeight">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentyeight" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentyeight">
                            Are subtitles available for shows on the EPIC On app?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentyeight" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentyeight">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Subtitles<!-- Not sure if we should say working towards it. Just specify the names of the shows  --><!-- Should we be listing shows which have subtitles? -->
         are available for selected shows as of now, but we are working
         towards enabling subtitles for all our content.</p>
         <li/>Following shows have subtitles.<br>
         <style>table.subtitles td{vertical-align:top;}></style>
         <table cellspacing="0" border="0" class="subtitles">
         <tbody>
         <!--tr>
            <td align="left" style="width:60px;">Sr. No</font></u></b></td>
            <td align="left">Show Title</font></u></b></td>
            </tr-->
         <tr>
         <td align="left" style="width:40px;">1</td>
         <td align="left">Adrishya</font></td>
         </tr>
         <tr>
         <td align="left">2</td>
         <td align="left">Dariba Diaries</font></td>
         </tr>
         <tr>
         <td align="left">3</td>
         <td align="left">Devlok with Devdutt Pattanaik S1</td>
         </tr>
         <tr>
         <td align="left">4</td>
         <td align="left">Indian Martial Arts</td>
         </tr>
         <tr>
         <td align="left">5</td>
         <td align="left">Indipedia</font></td>
         </tr>
         <tr>
         <td align="left">6</td>
         <td align="left">Kahi Suni</font></td>
         </tr>
         <tr>
         <td align="left">7</td>
         <td align="left">Made In India</font></td>
         </tr>
         <tr>
         <td align="left">8</td>
         <td align="left">Mid Wicket Tales with Naseeruddin Shah</font></td>
         </tr>
         <tr>
         <td align="left">9</td>
         <td align="left">Raja Rasoi Aur Andaaz Anokha (Season 1)</font></td>
         </tr>
         <tr>
         <td align="left">10</td>
         <td align="left">Raja Rasoi Aur Anya Kahaniyaan (Season 1)</font></td>
         </tr>
         <tr>
         <td align="left">11</td>
         <td align="left">Raja Rasoi Aur Anya Kahaniyaan (Season 2)</font></td>
         </tr>
         <tr>
         <td align="left">12</td>
         <td align="left">Rakkt (Season 1)</font></td>
         </tr>
         <tr>
         <td align="left">13</td>
         <td align="left">Rakkt (Season 2)</font></td>
         </tr>
         <tr>
         <td align="left">14</td>
         <td align="left">Sanrachna</font></td>
         </tr>
         <tr>
         <td align="left">15</td>
         <td align="left">Stories by Rabindranath Tagore </td>
         </tr>
         <tr>
         <td align="left">16</td>
         <td align="left">Time Machine</font></td>
         </tr>
         <tr>
         <td align="left">17</td>
         <td align="left">Tyohaar Ki Thaali (Season 1)</font></td>
         </tr>
         <tr>
         <td align="left">18</td>
         <td align="left">Tyohaar Ki Thaali (Season 2)</font></td>
         </tr>
         <tr>
         <td align="left">19</td>
         <td align="left">Yam Kisi Se Kam Nahi</font></td>
         </tr>
         <tr>
         <td align="left">20</td>
         <td align="left">Ekaant Sarhad Paar</font></td>
         </tr>
         <tr>
         <td align="left">21</td>
         <td align="left">Devlok with Devdutt Pattanaik S2</td>
         </tr>
         <tr>
         <td align="left">22</td>
         <td align="left">Devlok with Devdutt Pattanaik S3</td>
         </tr>
         <tr>
         <td align="left">23</td>
         <td align="left">The Great Escape(6 episodes)</td>
         </tr>
         <tr>
         <td align="left">24</td>
         <td align="left">Lost Recipes</td>
         </tr>
         <tr>
         <td align="left">25</td>
         <td align="left">Daanav Hunters</td>
         </tr>
         <tr>
         <td align="left">26</td>
         <td align="left">Dharmakshetra</td>
         </tr>
         <tr>
         <td align="left">27</td>
         <td align="left">Ekaant (Season 1)</td>
         </tr>
         <tr>
         <td align="left">28</td>
         <td align="left">Ekaant (Season 2)</td>
         </tr>
         <tr>
         <td align="left">29</td>
         <td align="left">Lost Recipes (Season 2)</td>
         </tr>
         <tr>
         <td align="left">30</td>
         <td align="left">Raja Rasoi Aur Andaaz Anokha (Season 2)</td>
         </tr>
         <tr>
         <td align="left">31</td>
         <td align="left">Regiment Diaries</td>
         </tr>
         <tr>
         <td align="left">32</td>
         <td align="left">Roz Sunday</td>
         </tr>
         <tr>
         <td align="left">33</td>
         <td align="left">Sharanam: Safar Vishwaas Ka... (Season 2)</td>
         </tr>
         <tr>
         <td align="left">34</td>
         <td align="left">Sharanam: Safar Vishwaas Ka... with Juhi Chawla</td>
         </tr>
         <tr>
         <td align="left">35</td>
         <td align="left">Siyaasat</td>
         </tr>
         <tr>
         <td align="left">36</td>
         <td align="left">Umeed India</td>
         </tr>
         <tr>
         <td align="left">37</td>
         <td align="left">A Tent, A Truck & Talkies</td>
         </tr>
         <tr>
         <td align="left">38</td>
         <td align="left">Air Battle of Srinagar</td>
         </tr>
         <tr>
         <td align="left">39</td>
         <td align="left">GD Bakshi - Air Battle of Srinagar</td>
         </tr>
         <tr>
         <td align="left">40</td>
         <td align="left">GD Bakshi - Killer Squadron</td>
         </tr>
         <tr>
         <td align="left">41</td>
         <td align="left">GD Bakshi - The 1965 Indo-Pakistan War</td>
         </tr>
         <tr>
         <td align="left">42</td>
         <td align="left">GD Bakshi - The Fall of Dhaka</td>
         </tr>
         <tr>
         <td align="left">43</td>
         <td align="left">Hai Junoon</td>
         </tr>
         <tr>
         <td align="left">44</td>
         <td align="left">Janani</td>
         </tr>
         <tr>
         <td align="left">45</td>
         <td align="left">Killer Squadron</td>
         </tr>
         <tr>
         <td align="left">46</td>
         <td align="left">Life Zara Hatke</td>
         </tr>
         <tr>
         <td align="left">47</td>
         <td align="left">Nagaland - The Hornbill Festival</td>
         </tr>
         <tr>
         <td align="left">48</td>
         <td align="left">Nagaland - The Sons of Jepfu</td>
         </tr>
         <tr>
         <td align="left">49</td>
         <td align="left">Royal Enfield - Brands of India</td>
         </tr>
         <tr>
         <td align="left">50</td>
         <td align="left">Rupa's Boutique</td>
         </tr>
         <tr>
         <td align="left">51</td>
         <td align="left">The 1965 Indo - Pakistan War</td>
         </tr>
         <tr>
         <td align="left">52</td>
         <td align="left">The Fall Of Dhaka</td>
         </tr>
         <tr>
         <td align="left">53</td>
         <td align="left">URI: THE FORGOTTEN BATTLE</td>
         </tr>
         <tr>
         <td align="left">54</td>
         <td align="left">Himalayan Misfits</td>
         </tr>
         <tr>
         <td align="left">55</td>
         <td align="left">Elephant Whisperer and Maya Memsaheb</td>
         </tr>
         <tr>
         <td align="left">56</td>
         <td align="left">Naga - The Eternal Yogi</td>
         </tr>
         <tr>
         <td align="left">57</td>
         <td align="left">Smile Pinki</td>
         </tr>
         <tr>
         <td align="left">58</td>
         <td align="left">The Pad Piper</td>
         </tr>
         <tr>
         <td align="left">59</td>
         <td align="left">Cyber Yodha</td>
         </tr>
         <tr>
         <td align="left">60</td>
         <td align="left">Balasinor Rediscover India's Dinosaurs</td>
         </tr>
         <tr>
         <td align="left">61</td>
         <td align="left">Raghu Rai</td>
         </tr>
         <tr>
         <td align="left">62</td>
         <td align="left">Curry Pow</td>
         </tr>
         <tr>
         <td align="left">63</td>
         <td align="left">Rampath</td>
         </tr>
         <tr>
         <td align="left">64</td>
         <td align="left">Nandadevi</td>
         </tr>
         <tr>
         <td align="left">65</td>
         <td align="left">Jewels Of The Sea</td>
         </tr>
         <tr>
         <td align="left">66</td>
         <td align="left">Tololing</td>
         </tr>
         <tr>
         <td align="left">67</td>
         <td align="left">Superman of Malegaon</td>
         </tr>
         <tr>
         <td align="left">68</td>
         <td align="left">Ghat Ghat Ka Paani</td>
         </tr>
         <tr>
         <td align="left">69</td>
         <td align="left">Beehad</td>
         </tr>
         <tr>
         <td align="left">70</td>
         <td align="left">Mahouts of Kerala</td>
         </tr>
         <tr>
         <td align="left">71</td>
         <td align="left">Wall Stories</td>
         </tr>
         <tr>
         <td align="left">72</td>
         <td align="left">Beyond Bollywood</td>
         </tr>
         <tr>
         <td align="left">73</td>
         <td align="left">Hit The Road</td>
         </tr>
         </tbody></table>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion29">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwentynine">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwentynine" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwentynine">
                            Do I have to pay to watch content?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwentynine" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwentynine">
                        <div class="accordion-body text-white">
                            <ul>
                             <li/>
                             <p lang="en-IN" style="">
                             EPIC On has both free and premium content. Except for premium
                             content, all other content can be enjoyed without paying any
                             charges.</p>
                             </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accord30">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirty">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirty" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirty">
                            How do I know what Content I have to pay for?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirty" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirty">
                        <div class="accordion-body text-white">
                            <ul>
                             <li/>
                             <p lang="en-IN" style="">
                             Except for premium content, all other content on EPIC On is free All
                             premium content comes with a 'PREMIUM' tag on it, so you can easily
                             identify them from the rest of the content.</p>
                             </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion31">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtyone">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtyone" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtyone">
                            How do you cast content from the EPIC On app on Chromecast?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtyone" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtyone">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Set up your Chromecast and connecting it to the same Wi-Fi network
         as your mobile device.</p>
         <li/>
         <p lang="en-IN" style="">
         Open the EPIC On App from your Android/iOS phone or tablet and
         select the video you want to cast.</p>
         <li/>
         <p lang="en-IN" style="">
         Select the Cast icon on the top-right corner of your screen to cast
         the content.</p>
         <li/>
         <p lang="en-IN" style="">
         Select the Chromecast device on which you want to cast the video.</p>
         <li/>
         <p lang="en-IN" style="">
         Your phone/tablet works just like a television remote controller.
         You can adjust volume, fast forward the video, and stop and play the
         video at your convenience.</p>
         <li/>
         <p lang="en-IN" style="">
         Click on the ‘Cast’ icon and select ‘Disconnect’ to stop
         casting.</p>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion32">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtytwo">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtytwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtytwo">
                            How can you cast content on Apple TV using an iOS device?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtytwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtytwo">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Your iOS device should be connected to the Apple TV <!-- Not sure about this.
            “Your iOS device should be connected to the Apple TV…”? --><!-- Changed. -->that
         you want to stream videos on.</p>
         <li/>
         <p lang="en-IN" style="">
         With the Airplay feature on your iOS device, select the option to
         watch videos on your Apple TV.</p>
         <li/>
         <p lang="en-IN" style="">
         Make sure your iOS device is on the same Wi-Fi network as your Apple
         TV.</p>
         <li/>
         <p lang="en-IN" style="">
         Select the video you want to watch from your device and press the
         Airplay button (this option will not show if you are not on the same
         Wi-Fi network as the device you wish to connect with).</p>
         <li/>
         <p lang="en-IN" style="">
         Select the Apple TV from the Airplay devices that show up, and your
         content will begin streaming on your Apple TV screen.</p>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion33">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtythree">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtythree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtythree">
                            How can you watch content from the EPIC On app on multiple devices simultaneously using the same account?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtythree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtythree">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Viewing content on multiple devices simultaneously using the same
         account is currently not supported on EPIC On.</p>
         <li/>
         <p lang="en-IN" style="">
         You will have to pause the content on the current device and click
         on play on the other device, after 10 seconds. The content will
         start playing on the second device.</p>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion34">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtyfour">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtyfour" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtyfour">
                            What can you do if you have already paid for your subscription but are still unable to access paid content on the EPIC On (and are asked to pay for subscription)?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtyfour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtyfour">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         Please make sure you are logged in on the same account you bought
         the subscription from.</p>
         <li/>
         <p lang="en-IN" style="">
         If you are asked to subscribe even after using the correct account,
         please get in touch with us via the Contact Us link on the
         app/website.</p>
         <li/>
         <p lang="en-IN" style="">
         Please make sure to attach the transaction receipt of your
         subscription in your email.</p>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion35">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtyfive">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtyfive" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtyfive">
                            How can you sign up on EPIC On?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtyfive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtyfive">
                        <div class="accordion-body text-white">
                            <ul>
         <li/>
         <p lang="en-IN" style="">
         We have five modes of signing up on EPIC On.</p>
         <ul>
         <li/>
         <p lang="en-IN" style="">
         - Email ID</p>
         <li/>
         <p lang="en-IN" style="">
         - Mobile Number</p>
         <li/>
         <p lang="en-IN" style="">
         - Facebook account</p>
         <li/>
         <p lang="en-IN" style="">
         - Twitter account</p>
         <li/>
         <p lang="en-IN" style="">
         - Google Plus account</p>
         </ul>
         <li/>
         <p lang="en-IN" style="">
         Use any of these methods to sign up on EPIC On.</p>
         <li/>
         <p lang="en-IN" style="">
         To sign up, click on the Sign In link on the website/app.</p>
         <li/>
         <p lang="en-IN" style="">
         Click on the Sign Up button, select any of the mentioned options to
         create an account on EPIC On.
         </p>
         </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion36">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtysix">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtysix" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtysix">
                            How do you get a refund?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtysix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtysix">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>
                             <p lang="en-IN" style=""><a name="_GoBack"></a>
                             EPIC On does not offer a refund policy. A one-time subscription,
                             once availed of, cannot be refunded.</p>
                             </li>
                             <li>
                             <p>However, in case your EPIC On subscription is set on auto-renewal,
                             you can disable it for the next cycle. This will ensure that your
                             subscription isn’t renewed once the current subscription period
                             ends.</p>
                             </li>
                             </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion37">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtyseven">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtyseven" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtyseven">
                            What can you do if your EPIC On app crashes repeatedly?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtyseven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtyseven">
                        <div class="accordion-body text-white">
                            <p>Our team of engineers have tested the app prior to release, but there may be unpredictable scenarios, given that there are various devices and OS versions.
         We do take crash reports very seriously. In the case of repeated app crashes, we request you to write to us on epicon@epicchannel.com. Do provide us with the details** mentioned at the end of this answer.
         A couple of quick checks that you will need to perform at your end before you report the issue to us:
         <ul><li>
         a. Have you enabled all necessary permissions for the EPIC On app on your device?
         <p>It needs Phone/SMS/Messaging and Storage permissions.
         Offline downloads will need Storage permission. To verify permissions, follow these steps:
         Go to Settings > Apps. Scroll down till you see EPIC On and click on it. Now, click on Permissions and enable both 'Phone' and 'Storage' permissions (Note: Options may be named differently on different phones).</p>
         </li><li>
         b. Have you installed any customized themes?
         <p>Some phones allow you to change the default theme. In some cases, themes may interfere with the functionality of some applications causing frequent app crashes. You might want to reset themes and check if that was causing it. Do write to us if the issue persists after you have reset the theme to default.</p></li></ul>
         **Send us the details of your device: User ID, Device Manufacturer, Device Model Number, Device OS and Version, EPIC On App Version.
         If possible, also send us a screenshot of your 'My Account' page.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion38">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtyeight">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtyeight" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtyeight">
                            GAMES
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtyeight" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtyeight">
                        <div class="accordion-body text-white">
                             <ul>
                <li>Where can I find Games?</li>
                On the Home Screen of EPIC ON, select PLAY and you will see a list of Games.<br>

                <li>Are games children friendly and non-violent?</li>
                We do not offer violent games.<br>

                <li>Can I play games without a valid subscription?</li>
                Yes, few games without premium tag are free to play<br>

                <li>Can I download premium games? And what's the limit?</li>
                No, games are not for downloads<br>

                <li>Do I have to pay extra to use this feature?</li>
                There are free games as well. Paid games are the part of the premium subscription<br>

                <li>On which EPIC ON platforms games are available to play?</li>
                Games are available to Play only on Android , IOS , Website<br>

            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion39">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThirtynine">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThirtynine" aria-expanded="false" aria-controls="panelsStayOpen-collapseThirtynine">
                            LISTEN
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThirtynine" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThirtynine">
                        <div class="accordion-body text-white">
                            <ul>
                <li>Do I have to pay extra to use this feature?</li>
                No, with one EPIC ON subscription pack you can enjoy the premium podcast, TV Shows, Movies, eBooks , Games<br>

                <li>Where can I find Podcasts?</li>
                On the Home Screen of EPIC On, select LISTEN and you will see a list of Podcasts.<br>

                <li>How can I get started with Podcasts?</li>
                To listen to premium Podcast you will need to have a valid subscription, we also have list of other Podcast that’s available for free<br>

                <li>Can I listen to a podcast without a valid subscription?</li>
                Yes, Podcast which are available for free to listen, however need a valid subscription listening to premium podcast<br>

                <li>Can I download a Podcast? And what's the limit?</li>
                Yes , you can download the podcast and there is no limit to download<br>

                <li>Podcasts are available on which EPIC ON platforms to read?</li>
                Podcast are available to Play only on Android , IOS , Website and
                Smart TV ( Coming Soon)"<br>

            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion40">
                    <h2 class="accordion-header" id="panelsStayOpen-headingForty">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseForty" aria-expanded="false" aria-controls="panelsStayOpen-collapseForty">
                            WATCH
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseForty" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingForty">
                        <div class="accordion-body text-white">
                            <ul>
                <li>What kind of content is available in the watch category ?</li>
                Content includes TV shows, Movies,  Documentaries , Shorts, Video Books ,Kids  across the genre<br>

                <li>Do I have to pay extra to use this feature?</li>
                No, with one EPIC ON subscription pack you can enjoy the premium content of watch, Listen , Play ,Read  categories<br>

                <li>How do you access the content in the watch category?</li>

                Click on the watch category on the home page and browse through all the content which includes TV shows, Movies,  Documentaries , Shorts, Video Books ,Kids  across the genre<br>

            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion41">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFortyone">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFortyone" aria-expanded="false" aria-controls="panelsStayOpen-collapseFortyone">
                            Can I get additional benefits and code discount at the same time ?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFortyone" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFortyone">
                        <div class="accordion-body text-white">
                            <ul>
                <li>You can go for discount coupon code or Additional benefits  one at a time<br>
            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion42">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFortytwo">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFortytwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseFortytwo">
                            When my EPICOINS on subscription will be added in the reward store account?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFortytwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFortytwo">
                        <div class="accordion-body text-white">
                            <ul>
                 <li> EPICOINS on the subscription  will be updated within 48 hours in the user's EPICOINS balance account in the reward store.</li>
             </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion43">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFortythree">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFortythree" aria-expanded="false" aria-controls="panelsStayOpen-collapseFortythree">
                            I am not able to see the coupon code option after clicking on the renew or upgrade plan tab?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFortythree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFortythree">
                        <div class="accordion-body text-white">
                            <ul>
                             <li>You can see coupon code option only for new subscription and once active subscription is over</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot" id="accordion44">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFortyfour">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFortyfour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFortyfour">
                            Amazon Pay cashback offer is available on which plans?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFortyfour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFortyfour">
                        <div class="accordion-body text-white">
                            <ul>
                                 <li> Amazon pay cashback offer is available on 1 month, 3 month, 6 month and 12 month plan once per user</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="feedbackForm">
            <div class="col-sm-12">
                <h4 class="text-white mb-4">{{__('Need More Help?')}}</h4>
            </div>
            <div class="col-sm-12 need-help">
                <p class="para-help">{{__('Write your query/feedback below and we will reach out to you within 24 hours.')}}</p>
                <textarea name="feedback" id="" cols="122" rows="5" placeholder="{{__('Type your query here...')}}"></textarea>
                <div class="error-msg text-center text-danger pt-2"></div>
                <div class="success-msg text-center text-success pt-2"></div>
            </div>
            <button type="button" class="need-button">
                {{__('Submit')}}
                <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.94922 12C4.94922 11.5858 5.28501 11.25 5.69922 11.25H19.6992C20.1134 11.25 20.4492 11.5858 20.4492 12C20.4492 12.4142 20.1134 12.75 19.6992 12.75H5.69922C5.28501 12.75 4.94922 12.4142 4.94922 12Z" fill="#070707" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1689 4.46967C12.4618 4.17678 12.9367 4.17678 13.2295 4.46967L20.2295 11.4697C20.5224 11.7626 20.5224 12.2374 20.2295 12.5303L13.2295 19.5303C12.9367 19.8232 12.4618 19.8232 12.1689 19.5303C11.876 19.2374 11.876 18.7626 12.1689 18.4697L18.6386 12L12.1689 5.53033C11.876 5.23744 11.876 4.76256 12.1689 4.46967Z" fill="#0000007a" />
                    </svg></span>
            </button>
        </form>
    </div>

</section>

@stop

@section('script')

<script>
    $(document).ready(function() {
        $("#feedbackForm button").click(function() {
            $("#feedbackForm .success-msg, #feedbackForm .error-msg").html("");
            var feedback = $("#feedbackForm textarea").val();
            if (feedback.trim() == "") {
                $("#feedbackForm .error-msg").html("Query/Feedback is required");
                return;
            }
            var formData = $('#feedbackForm').serialize();
            if (formData != '') {
                $.ajax({
                    url: "{{ route('save-feedback') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.payload.success == true) {
                            $("#feedbackForm textarea").val('');
                            $("#feedbackForm .success-msg").html("Your Feedback updated. We will reach out to you within 24 hours.");
                        } else {
                            if (response.payload.errorcode == "2002") {
                                $("#feedbackForm .error-msg").html("You are not logged in.");
                            } else {
                                $("#feedbackForm .error-msg").html(response.payload.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        onError(xhr); 
                    }
                });
            } else {
                $("#feedbackForm #error-msg").html("Please type your query.");
            }
        })

    });

    $("#search-feedback").on('keyup', function() {
            var value = $(this).val().toLowerCase();
            var status = false;
            $("#accordionPanelsStayOpenExample .accordion-item").each(function() {
                if ($(this).text().toLowerCase().search(value) > -1) {
                    $(this).show();
                    status = true;
                    // $(this).prev('.subjectName').last().show();
                } else {
                    $(this).hide();
                  //  $("#noData-error").show();
                }
            });
            if(status == false) {
                $("#noData-error").show();
            }else{
                $("#noData-error").hide();
            }
    });

</script>

@stop
