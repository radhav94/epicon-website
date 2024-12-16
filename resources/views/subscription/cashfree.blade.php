<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashfree Checkout Integration</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>

<body>
    <div class="row">
        <button id="renderBtn" style="visibility:hidden;">Pay Now</button>
    </div>
    <script>
        const cashfree = Cashfree({
            mode: "{{ $parameters['cashfree_env'] }}",
        });
        document.getElementById("renderBtn").addEventListener("click", () => {
            let checkoutOptions = {
                paymentSessionId: "{{ $parameters['payment_session_id'] }}",
                // redirectTarget: "_self",
            };
            cashfree.checkout(checkoutOptions);
        });
        setTimeout(() => {
            document.getElementById("renderBtn").click();
        });
    </script>
</body>

</html>
