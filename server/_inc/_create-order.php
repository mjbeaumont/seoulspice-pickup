<?php

// the following are set in /_inc/config.php
/**
 * @var $config array of configuration values
 * @var $api_client \SquareConnect\ApiClient
 */

$orderBuilder = new \SSPickup\models\OrderBuilder($data, $config['location_id']);

// $api_client set in _inc/process-payment.php
$orders_api = new \SquareConnect\Api\OrdersApi($api_client);
$body = new \SquareConnect\Model\CreateOrderRequest();

$body->setIdempotencyKey(uniqid( '', true ));
$orderBody = new \SquareConnect\Model\Order();
$body->setOrder($orderBuilder->getOrder());

try {
	$order_result = $orders_api->createOrder($config['location_id'], $body);
	$order = $order_result->getOrder();
	$payment_log->info('Order successfully processed: ', (array)$order);

	$payBody = new \SquareConnect\Model\PayOrderRequest();
	$payBody->setIdempotencyKey(uniqid( '', true ));
	$payBody->setPaymentIds([
		$payment->getId()
	]);
	try {
		$payorder_result = $orders_api->payOrder($order->getId(), $payBody);
		$payment_log->info('Order successfully paid: ', [
			'payment_id' => $payment->getId(),
			'order_id' => $order->getId()
		]);
	} catch (\SquareConnect\ApiException $e) {
		$error_log->error( 'Exception when calling OrdersApi->payOrder:', json_decode(json_encode($e->getResponseBody()), true));
	}
} catch (\SquareConnect\ApiException $e) {
	$error_log->error( 'Exception when calling OrdersApi->createOrder:', json_decode(json_encode($e->getResponseBody()), true));
}


