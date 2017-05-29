<?php
	require_once('../../Configuration.php');
	
	//-- FMS DATA API call: Authenticate by passing the oAuth Request Id and Identifier
	$url = "https://" . SERVER . "/fmi/rest/api/auth/Companies";
	
	// Get Request Id from storage, assumed that this is handled by the oAuthConnector scripts first
	$fileRequestId = fopen('../../Storage/RequestId.txt','r');
	$requestId = fread ( $fileRequestId, filesize('../../Storage/RequestId.txt') );
	
	// Get Identifier from storage, assumed that this is handled by the oAuthConnector scripts first
	$fileIdentifier = fopen('../../Storage/Identifier.txt','r');
	$identifier = fread ( $fileIdentifier, filesize('../../Storage/Identifier.txt') );
	
	$arrData['oAuthRequestId'] = $requestId ;
	$arrData['oAuthIdentifier'] = $identifier;
	$arrData['layout'] = 'Companies';
	
	$jsonData = json_encode($arrData) ;
	
	//echo $jsonData ; exit() ;
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json','X-FM-Data-Login-Type:oauth')) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST , 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	
	$output = curl_exec($ch) ;
	
	
	curl_close($ch) ;
	
	//print_r($output) ;
	
	// Parse the response and fetch the Access Token. Some error handling would be a great idea!
	
	$arrResponse = json_decode ($output, true) ;
	//print_r($arrResponse) ;
	$accessToken = $arrResponse['token'];
	
	//-- FMS DATA API call: Get a list of all records
	$url = "https://" . SERVER . "/fmi/rest/api/record/Companies/Companies";
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json','FM-Data-Token:' . $accessToken)) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$output = curl_exec($ch) ;
	
	// Display the raw JSON output
	print_r($output);