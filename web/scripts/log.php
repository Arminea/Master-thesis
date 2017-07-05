<?php

require_once ('const.php');
require_once('Logger.php');

if(!empty($_POST)){
	$message = $_POST['message'];

	$logger = new Logger();
	$logger->AppendMessage(ERR_MESS, $message);
}

?>