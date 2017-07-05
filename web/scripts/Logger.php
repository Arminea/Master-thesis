<?php

class Logger {

	private $fileName;
	const PATH = "/pdetect/log/";

	public function __construct() {
		date_default_timezone_set('Europe/Prague');
		$this->fileName = date("Y-m-d") . "_Log.txt";
	}


	public function AppendMessage($const, $mess) {
		$filePath = $_SERVER['DOCUMENT_ROOT'] . self::PATH . $this->fileName;
		echo $filePath;
		$content = date("H:i:s") . " " . $const . " " . $mess . "\n";
		// Write the contents to the file, 
		// using the FILE_APPEND flag to append the content to the end of the file
		// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
		// returns false on failure
		$isFileCreated = file_put_contents($filePath, $content, FILE_APPEND | LOCK_EX);
		echo "Text: " . $isFileCreated;
	}
	

}

?>