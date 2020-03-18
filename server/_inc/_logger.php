<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$error_log = new Logger('error');
$error_log->pushHandler(new StreamHandler('log/errors.log', Logger::WARNING));

$payment_log = new Logger('payment');
$payment_log->pushHandler(new StreamHandler('log/payments.log', Logger::WARNING));