<?php

require_once('Stats.php');

if(!empty($_POST)){
	$stats = new Stats();
	$stats->AppendRecord();
}

?>