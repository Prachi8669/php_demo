<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['PName'], $_POST['PPrice'], $_POST['PQuantity'])) {
    $product_name = $_POST['PName'];
    $product_price = $_POST['PPrice'];
    $product_quantity = (int)$_POST['PQuantity']; // Quantity को integer में convert करना।

    // अगर session में cart मौजूद नहीं है, तो उसे initialize करें।
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // चेक करें कि यह प्रोडक्ट पहले से cart में है या नहीं
    $product_exists = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['productName'] == $product_name) {
            // अगर प्रोडक्ट पहले से cart में है, तो quantity बढ़ा दें
            $_SESSION['cart'][$key]['productQuantity'] += $product_quantity;
            $product_exists = true;
            break;
        }
    }

    // अगर प्रोडक्ट cart में नहीं है, तो उसे जोड़ दें
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'productName' => $product_name,
            'productPrice' => $product_price,
            'productQuantity' => $product_quantity
        ];
    }

    // फिर से viewCart.php पेज पर रिडायरेक्ट करें।
    header('location:viewCart.php');
    exit();
}
?>
