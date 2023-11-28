<html>
<head>
    <title>Paymoney</title>
</head>
<body>
 
    <form method="post" name="redirect" action="{{$parameters['payuUrl']}}">
        <input type=hidden name="key" value="{{ $parameters['key'] }}">
        <input type=hidden name="hash" value="{{ $parameters['hash'] }}">
        <input type=hidden name="txnid" value="{{ $parameters['txnid'] }}">
        <input type=hidden name="amount" value="{{ $parameters['amount'] }}">
        <input type=hidden name="firstname" value="{{ $parameters['firstname'] }}">
        <input type=hidden name="email" value="{{ $parameters['email'] }}">
        <input type=hidden name="phone" value="{{ $parameters['phone'] }}">
        <input type=hidden name="productinfo" value="{{ $parameters['productinfo'] }}">
        <input type=hidden name="surl" value="{{ $parameters['surl'] }}">
        <input type=hidden name="furl" value="{{ $parameters['furl'] }}">
        <input type=hidden name="api_version" value="7">
        <input type=hidden name="lastname" value="{{ (@$parameters['lastname'] != '') ? $parameters['lastname'] : '' }}">
        <input type=hidden name="pg" value="{{ (@$parameters['pg'] != '') ? $parameters['pg'] : '' }}">
    </form>
 <script language='javascript'>document.redirect.submit();</script> 
</body>
</html>

