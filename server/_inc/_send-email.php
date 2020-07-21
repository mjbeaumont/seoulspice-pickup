<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$emailBuilder = new \SSPickup\models\EmailBuilder($data);
$mail = new PHPMailer(true);

try {
	//Server settings
	$mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'order@seoulspice.com';                     // SMTP username
	$mail->Password   = 'Seoulspice2016!';                               // SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	$mail->Port       = 587;                                    // TCP port to connect to
	$mail->CharSet = 'UTF-8';

	//Recipients
	$mail->setFrom('order@seoulspice.com', 'Seoulspice Orders');
	$mail->addAddress($data->order->email, $data->order->name);     // Add a recipient
	$mail->addReplyTo('order@seoulspice.com', 'Seoulspice Orders');
	if ($env !== 'dev') {
		$mail->addCC($data->order->location->email);
	}
	$mail->addBCC('matt@beaumontwebdev.com');

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'SEOULSPICE Pickup Order Confirmation';
	$mail->Body    = $emailBuilder->getBody();

	$mail->send();
	$response['success'] = true;
} catch (Exception $e) {
	$response['message'] =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}