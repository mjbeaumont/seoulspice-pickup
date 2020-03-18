<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("vendor/autoload.php");

$env = 'dev';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$response = ['success' => false, 'message' => ''];
$formData = file_get_contents( 'php://input' );
$data = json_decode( $formData, false);

include('./_inc/_logger.php');
include('./_inc/_process-payment.php');



