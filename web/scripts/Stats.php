<?php

class Stats {
	private $fileName;
	const PATH = "/pdetect/log/";

	public function __construct() {
		date_default_timezone_set('Europe/Prague');
		$this->fileName = "statistics.xml";
	}

	/*
	*
	*/
	public function AppendRecord() {
		$filePath = $_SERVER['DOCUMENT_ROOT'] . self::PATH . $this->fileName;

		$details = json_decode(file_get_contents("http://ipinfo.io/". $_SERVER['REMOTE_ADDR'] ."/json"));
		// print_r($details);
		// (true ? 'true' : false)
		$ip = (array_key_exists('ip', $details) ? $details->ip : "" );
		$hostname = (array_key_exists('hostname', $details) ? $details->hostname : "" );
		$city = (array_key_exists('city', $details) ? $details->city : "" );
		$region = (array_key_exists('region', $details) ? $details->region : "" );
		$country = (array_key_exists('country', $details) ? $details->country : "" );
		$loc = (array_key_exists('loc', $details) ? $details->loc : "" );
		$org = (array_key_exists('org', $details) ? $details->org : "" );

		$content = 	"<record>".
						"<ip>". $ip ."</ip>".
						"<hostname>". $hostname."</hostname>".
						"<city>". $city ."</city>".
						"<region>". $region ."</region>".
						"<country>". $country ."</country>".
						"<loc>". $loc ."</loc>".
						"<org>". $org ."</org>".
					"</record>\n";

		// Write the contents to the file, 
		// using the FILE_APPEND flag to append the content to the end of the file
		// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
		// returns false on failure
		file_put_contents($filePath, $content, FILE_APPEND | LOCK_EX);
	}
}

?>