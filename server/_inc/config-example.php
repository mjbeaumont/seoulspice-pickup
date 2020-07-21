<?php

// this file must be included after $env is set and $_POST data is assign to $data

if ($env === 'dev') {
	$config = [
		'location_id' => '',  // Square Location ID
		'square' => [
			'access_token' => '', // Square Access Token
			'host' => 'https://connect.squareupsandbox.com',
			'debug' => true
		]
	];
} else {
	$config = [
		'location_id' => $data->order->location->id,
		'square' => [
			'access_token' => '',
			'host' => 'https://connect.squareup.com',
			'debug' => false
		]
	];
}

$api_config = new \SquareConnect\Configuration();
$api_config->setHost($config['square']['host']);
$api_config->setAccessToken($config['square']['access_token']);
$api_config->setDebug($config['square']['debug']);
$api_client = new \SquareConnect\ApiClient($api_config);