<?php

// Page links
define("INDEX_PAGE", "../index.php");

// Contact form
define ("MSG_TO", "arminea@seznam.cz");
define ("SUBJ", "Master thesis question");
define ("SMTP_User", "pdetect@seznam.cz");
define ("SMTP_Pass", "boruvka68");
define ("CONTACT_FORM_YAP", "The email message was sent.");
define ("CONTACT_FORM_NOPE", "The email message could not be sent.");

// Log
define ("ERR_MESS", "[ERROR]");
define ("INFO_MESS", "[INFO]");
define ("FEEDBACK_MESS", "[FEEDBACK]");
define ("DBG_MESS", "[DEBUG]");

// Error codes
$errorCodes = array(
400 => array('400 Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
403 => array('403 Forbidden', 'The server has refused to fulfil your request.'),
404 => array('404 Not Found', 'The page you requested was not found on this server.'),
405 => array('405 Method Not Allowed', 'The method specified in the request is not allowed for the specified resource.'),
408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
502 => array('502 Bad Gateway', 'The server received an invalid response while trying to carry out the request.'),
504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);

define("UNEXPECTED_ERROR_TITLE", "Unexpected error");
define("UNEXPECTED_ERROR_MESSAGE", "An unexpected error has occured.");

?>