<?php
error_reporting(E_ALL); 
require_once ('const.php');
require_once('Logger.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	date_default_timezone_set('Europe/Prague');

	$name = test_input($_POST["name"]);
	$email = test_input($_POST["email"]);
	$message = test_input($_POST["message"]);

	// convert string to requested character encoding
	iconv("UTF-8", "UTF-8//IGNORE", $name);
	iconv("UTF-8", "UTF-8//IGNORE", $email);
	iconv("UTF-8", "UTF-8//IGNORE", $message);

	$logger = new Logger();

	$text = 'From: '. $name .' ('. $email .')' . "<br/><br/>";
	$text .= $message;

	$mail = new PHPMailer();

	$mail->isSMTP();                                // Set mailer to use SMTP
	$mail->Host = 'smtp.seznam.cz';  				// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                         // Enable SMTP authentication
	$mailer->Mailer = "smtp";
	$mailer->AuthType = "LOGIN";
	$mail->Username = SMTP_User;                 	// SMTP username
	$mail->Password = SMTP_Pass;                    // SMTP password
	$mail->SMTPSecure = 'ssl';                      // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                              // TCP port to connect to
	$mail->CharSet = 'UTF-8';

	// https://napoveda.seznam.cz/cz/email/imap-pop3-smtp/

	$mail->setFrom(SMTP_User);
	$mail->addAddress(MSG_TO);     // Add a recipient

	$mail->isHTML(true);    // Set email format to HTML

	$mail->Subject = SUBJ;
	$mail->Body    = $text;

	if(!$mail->send()) {
	    echo $mail->ErrorInfo;
	    http_response_code(500);

	} else {
	    http_response_code(200);
	}
		
	$ip = $_SERVER['REMOTE_ADDR'];
	$details = json_decode(file_get_contents("http://ipinfo.io/". $ip ."/json"));
	$infoMessage = "The email message was sent from ". $name ." (". $email .") - ". $details->city ." (". $details->country . ").";
	$logger->AppendMessage(INFO_MESS, $mail->ErrorInfo);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>