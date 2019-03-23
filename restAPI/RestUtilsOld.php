<?php
require_once 'template.php';



class RestUtils{

	//	public static function processRequest()
	//	{
	//		$return_obj	= new RestRequest();
	//		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
	//		$return_obj->setMethod($request_method);
	//
	//
	//		$data = null;
	//		switch ($request_method)
	//		{
	//			case 'get':
	//				if ($tmp = file_get_contents('php://input')) {
	//					$data = json_decode($tmp);
	//				}else{
	//					$data = $_GET;
	//				}
	//
	//				$return_obj->setData($data);
	//				break;
	//
	//		}
	//		$return_obj->setRequestVars($data);
	//
	//
	//
	//		return $return_obj;
	//	}

	public static function sendResponse($status = 200, $content = '', $content_type = 'text/html')
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
		// set the status
		header($status_header);
		// set the content type
		header('Content-type: ' . $content_type);

		if (!$content){
			// create some body messages
			$message = '';

			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templatized in a real-world solution

			$content = '<h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>
								<p>' . $message . '</p>
								<hr />
								<address>' . $signature . '</address>';
		}
		if(strcasecmp($content_type, 'text/html') === 0){
			$title = 'inContextSensing | RDF4Sensors '.$status;
			//			printHeader($title, "../");
			print '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>'. $title .'</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<link href="lib/calendar/calendar/calendar.css" rel="stylesheet"
	type="text/css" />
<script language="javascript" src="lib/calendar/calendar/calendar.js"></script>
</head>
<body onload="">
<div class="main">
<div class="header" title="Philips bubble mood sensing dress">
<div class="header_resize">
<div class="logo">
<h1><a href="#">inContext<span>Sensing</span> <small>Augment your sensor
data</small></a></h1>
</div>
<div class="clr"></div>
<div class="htext">
<h2>Linked Sensor Data</h2>
<p>Augment Pachube sensor data with additional contextual information
from the Web of Data.</p>
</div>
<div class="clr"></div>
<div class="menu_nav">
<ul>
	<li><a href="index.php">Home</a></li>
	<li class="active"><a href="snippetGen.php">RDF4Sensors</a></li>
	<li><a href="about.php">About Us</a></li>
</ul>

</div>
<div class="clr"></div>
</div>
</div>
<div class="content">

<div class="content_resize">

<div class="sidebar"></div>

<div class="mainbar">
<div class="article" style="color: black;">

<div class="clr"></div>
'.$content.'</div>

</div>

<div class="clr"></div>
</div>
</div>
<div class="fbg">
<div class="fbg_resize">
<div class="col c1"></div>
<div class="col c3"></div>
<div class="clr"></div>
</div>
</div>
<div class="footer">
<div class="footer_resize">
<p class="lf">&copy; Copyright <a href="http://www.deri.ie">DERI</a>.</p>
<p class="rf">Layout by Rocket <a
	href="http://www.rocketwebsitetemplates.com/">Website Templates</a></p>
<div class="clr"></div>
</div>
</div>
</div>
</body>
</html>';
		}else{
			echo $content;

		}
	}

	public static function getStatusCodeMessage($status)
	{
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
		);

		return (isset($codes[$status])) ? $codes[$status] : '';
	}

}

?>