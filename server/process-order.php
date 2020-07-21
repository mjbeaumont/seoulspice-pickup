<?php

require_once('vendor/autoload.php');
require_once('models/EmailBuilder.php');
require_once('models/OrderBuilder.php');
require_once('models/OrderItem.php');

$env = 'dev';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

$response = ['success' => false, 'message' => ''];
$formData = file_get_contents( 'php://input' );
$data = json_decode( $formData, false);

include('./_inc/config.php');
include('./_inc/_logger.php');
include('./_inc/_process-payment.php');
include('./_inc/_send-email.php');
include('./_inc/_create-order.php');

echo json_encode( $response );


