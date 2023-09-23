
<form method="POST" action="https://test.payu.in/_payment">
    @csrf

        <?php 
        
        //$HASH = "gtKFFx|txnid9628880113234368|10.00|epicon|ramv|ramv339@gmail.com|||||||||||4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW";
        $txnid ="12987867812";
        $amount = "10.00";
        $productinfo ="epicon";
        $username = "ramv";
        $email ="email";
         $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY')."|".$txnid."|".$amount."|".$productinfo."|".$username."|".$email."|||||||||||".config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');

        $calculated_hash = strtolower(hash("sha512", $HASH));
        ?>
    <div> 
    <input type="text" name="key" value="gtKFFx"><br>
    <input type="text" name="amount" value="{{$amount}}"><br>
    <input type="text" name="email" value="{{$email}}"><br>
    <input type="text" name="productinfo" value="{{$productinfo}}"><br>
    <input type="text" name="furl" value="http://local.epicon-revamp-v3.com/payufail"><br>
    <input type="text" name="txnid" value="{{$txnid}}"><br>
    <input type="text" name="firstname" value="{{$username}}"><br>
    <input type="text" name="phone" value="9819208025"><br>
    <input type="text" name="surl" value="http://local.epicon-revamp-v3.com/payusuccess"><br>
    <input type="text" name="hash" value="{{$calculated_hash}}"><br>
    <input type="submit" name="submit" value="Submit">

    </div>

</form>