<?php

require_once ('const.php');
require_once('feedback.php');
require_once('Logger.php');

if(!empty($_POST)){
	$isCorrect = $_POST['feedback'];
	$path = $_POST['path'];
	$Pclass = $_POST['Pclass'];

	$feedback = new Feedback($path, $isCorrect);

	$isRenamed = $feedback->renameImagePath();

	if ($isRenamed = 1) {
		$result = $feedback->resultToString();

		$logger = new Logger();

		$logger->AppendMessage(FEEDBACK_MESS, $result);
	}

}

?>