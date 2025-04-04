<?php
session_start();

if (!isset($_SESSION['ORDER_TOTAL'])) {
    echo "<script>
    alert('No order total found! Redirecting to checkout.');
    window.location.href='checkout.php';
    </script>";
    exit();
}

$orderTotal = $_SESSION['ORDER_TOTAL'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentMethod = $_POST['payment_method'];
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 20px;
            }
            .box {
                border: 2px solid #ccc;
                padding: 20px;
                display: inline-block;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <h2>Order Summary</h2>
        <div class="box">
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($paymentMethod); ?></p>
            <p><strong>Order Amount:</strong> ₹<?php echo htmlspecialchars($orderTotal); ?></p>
            <?php if ($paymentMethod == "Pay Online") { ?>
                <p>Payment Successful via UPI. Your order will be processed shortly.</p>
            <?php } else { ?>
                <p>Payment will be collected on delivery.</p>
            <?php } ?>
            <a href="index.php"><button>Go Back</button></a>
        </div>
    </body>
    </html>

    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .square-container {
            width: 350px;
            height: 350px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .payment-option {
            border: 2px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            cursor: pointer;
            width: 80%;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .selected {
            border-color: purple;
            background-color: #f3e5f5;
        }
        #qrCode {
            display: none;
            margin-top: 20px;
        }
        #placeOrder {
            background-color: purple;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="square-container">
    <h3>Select Payment Method</h3>
    <form id="paymentForm" action="payment.php" method="post">
        <input type="hidden" name="payment_method" id="paymentMethod" value="Cash on Delivery">
        <input type="hidden" name="order_total" value="<?php echo $orderTotal; ?>">

        <div class="payment-option selected" onclick="selectPayment('cod')">
            <input type="radio" name="payment" value="cod" checked> Cash on Delivery
        </div>

        <div class="payment-option" onclick="selectPayment('online')">
            <input type="radio" name="payment" value="online">  Pay Online
        </div>

        <div id="qrCode"></div>

        <button type="submit" id="placeOrder">Place Order</button>
    </form>
</div>

<script>
    function selectPayment(method) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));

        if (method === 'cod') {
            document.getElementById("paymentMethod").value = "Cash on Delivery";
            document.getElementById("qrCode").style.display = "none";
        } else {
            document.getElementById("paymentMethod").value = "Pay Online";
            document.getElementById("qrCode").style.display = "block";

            var orderTotal = document.querySelector('input[name="order_total"]').value;
            generateQRCode("upi://pay?pa=merchant@upi&pn=MerchantName&mc=123456&tid=ABC123&tr=TXN123&tn=Payment&am=" + orderTotal + "&cu=INR");
        }
        event.currentTarget.classList.add("selected");
    }

    function generateQRCode(data) {
        document.getElementById("qrCode").innerHTML = "";
        new QRCode(document.getElementById("qrCode"), {
            text: data,
            width: 128,
            height: 128
        });
    }
</script>

</body>
</html>