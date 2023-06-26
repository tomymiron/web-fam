<?php
    require 'vendor/autoload.php';
    MercadoPago\SDK::setAccessToken('APP_USR-3773039001945092-100823-6792ba08a82301f8036230ad8f8b1964-1213893476');

    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = '0001';
    $item->title = 'Inscripcion FAM';
    $item->quantity = 1;
    $item->unit_price = 750.00;
    $item->currency_id = 'ARS';

    $preference->items = array($item);
    $preference->back_urls = array(
        'success' => 'http://localhost/success.php',
        'failure' => 'http://localhost/fail.php'
    );

    $preference->auto_return = 'approved';
    $preference->binary_mode = true;
    
    $preference->save();
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>TestMP</title>

        <script src="https://sdk.mercadopago.com/js/v2"></script>
    </head>
    <body>
        <h1>Test mercado pago api</h1>
        <div class='checkout-btn'></div>

        <script>
            const mp = new MercadoPago('APP_USR-5c54a669-56b0-4bf2-9c50-91567537995d', {
                locale: 'es-AR'
            });

            mp.checkout({
                preference: {
                    id: '<?php echo $preference->id; ?>'
                },
                render: {
                    container: '.checkout-btn',
                    label: 'Pagar con MP'
                }
            });
        </script>
    </body>
</html>