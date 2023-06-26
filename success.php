<?php

$payment = $_GET['payment_id'];
$status = $_GET['status'];
$paymentType = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];

echo '<h1>Pago exitoso</h1>';
echo $payment . '<br>' . $status . '<br>' . $paymentType . '<br>' . $order_id;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/$payment");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = [
    'Authorization: Bearer APP_USR-3773039001945092-100823-6792ba08a82301f8036230ad8f8b1964-1213893476'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec($ch);
curl_close($ch);

print $server_output;
echo '<script>console.log( ' . $server_output . ' );</script>'
?>