<?php

function getHumanErrorMessage($error) {
	switch ($error->code) {
		case 'GENERIC_DECLINE':
		case 'PAN_FAILURE':
			return 'Card declined. Please try again.';
			break;
		case 'CVV_FAILURE':
			return 'CVV does not match.';
			break;
		case 'INVALID_EXPIRATION':
			return 'Invalid Expiration date.';
			break;
		case 'ADDRESS_VERIFICATION_FAILURE':
			return 'Incorrect billing zip';
		default:
			return $error->detail;
	}
}

// the following are set in /_inc/config.php
/* @var $config array of configuration values */
/* @var $api_client \SquareConnect\ApiClient

/* process payment */

$payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
$body = new\SquareConnect\Model\CreatePaymentRequest();
$amountMoney = new \SquareConnect\Model\Money();

// amount needs to be in cents
$amountMoney->setAmount((int)($data->totals->total * 100));
$amountMoney->setCurrency('USD');

$body->setSourceId($data->nonce);
$body->setAmountMoney($amountMoney);
$body->setLocationId($config['location_id']);
$body->setBuyerEmailAddress($data->order->email);
$body->setNote('Pickup Order for ' . $data->order->name);

$body->setIdempotencyKey(uniqid( '', true ));

try {
	$payment_result = $payments_api->createPayment($body);
	$payment = $payment_result->getPayment();
	$payment_log->info('Payment successfully processed: ', (array)$payment);
} catch (\SquareConnect\ApiException $e) {
	$error_log->error( 'Exception when calling PaymentsApi->createPayment:', json_decode(json_encode($e->getResponseBody()), true));
	$responseBody = $e->getResponseBody();
	$message_array = array_map( static function($error) {
		return getHumanErrorMessage($error);
	}, $responseBody->errors);
	$response['message'] = implode('<br>', $message_array);
	echo json_encode($response);
	exit;
}

