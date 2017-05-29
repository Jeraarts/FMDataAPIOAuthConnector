<?php
	require_once ( '../../Configuration.php') ;
	
	$provider = isset($_REQUEST['provider']) ? $_REQUEST['provider'] : 'Google' ;
	$trackingID = isset($_REQUEST['trackingID']) ? $_REQUEST['trackingID'] : '' ;
	
	$url = "http://" . SERVER . "/oauth/getoauthurl?trackingID=" . $trackingID . "&provider=" . $provider  ."&address=" . SERVER . "&X-FMS-OAuth-AuthType=2";
	$log = '';$log = '';
	
	
	//-- GET A REQUEST ID AND AUTHENTICATION URL FOR OAUTH PROVIDER
	
	$currentDirectory = substr ( str_replace ( '\\', '/' , realpath ( dirname ( __FILE__))), strlen ( str_replace ( ' \\', '/', realpath($_SERVER['DOCUMENT_ROOT']))));;
	$arrayHeaders = array(
		'X-FMS-Application-Type:9', 
		'X-FMS-Application-Version:15', 
		'X-FMS-Return-URL:https://' . SERVER . $currentDirectory . '/oAuthGetIdentifier.php'
		);
		
	// print_r($arrayHeaders); exit();

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeaders ) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$output = curl_exec($ch) ;
	curl_close($ch) ;
	
	//print_r($output) ; exit();
	
	// Parse output and get Request ID
	$start = strpos($output, 'X-FMS-Request-ID:',0) + 18;
	$end = strpos($output, "\r", $start ) ;
	$length = $end - $start;
	$requestId = substr($output, $start, $length) ;
	
	$startAuthURL = strpos($output, 'https://',0);
	$endAuthURL = strlen($output);
	$length = $end - $start;
	$authURL = substr($output, $startAuthURL, $endAuthURL) ;
	
	//$log .=  date("Y-m-d H:i:s") . ": " .  "Start position Request ID: " . $start ;
	//$log .=  date("Y-m-d H:i:s") . ": " .  ". End position Request ID: " .  $end ;
	
	//echo $requestId ;
	
	$file = fopen('../../storage/RequestId.txt','w');
	$result = fwrite($file, $requestId);
	$result = fclose($file);
	
	//$log .=  date("Y-m-d H:i:s") . ": " .  "Start position OAuth provider authentication URL: " .  $start ;
	//$log .=  date("Y-m-d H:i:s") . ": " .  "End position OAuth provider authentication URL: " .   $end ;

	$authURLnew = (  str_replace(' ', '+', $authURL) ) ;
	//$log .=  date("Y-m-d H:i:s") . ": oAuth authentication URL \n" . $authURLnew; 
	
	//echo "\n\n<br/>-------<br/>\n\n";
	
	//print_r($output) ;
	$log .=  date("Y-m-d H:i:s") . ": Raw Output from RequestId call to FMS:\n" . $output; 
	
	
	//-- CALL TO OAUTH AUTHENTICATION URL
	
	$ch = curl_init($authURLnew);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	$output = curl_exec($ch) ;
	//$info = curl_getinfo($chNew) ;
	
	curl_close($ch) ;
	if(!$output) {
		$log .=  date("Y-m-d H:i:s") . ": " . "Error calling authentication/authorization URL from oAuth Provider\n";
	}  ;
		
	//print_r($output) ;
	//print_r($info) ;
	