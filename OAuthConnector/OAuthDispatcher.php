<?php
	use  ClickWorks\FMDataAPIOAuthConnector;

	require_once ( '../Configuration.php') ;
	require_once ( 'Class.FMDataAPIOAuthConnector.php') ;
	
	/**
	* The action parameter (used in a GET or POST request) tells the dispatcher script what to do
	*/
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'GetIdentifier' ;
	
	switch ( $action) {
		
		/**
		*	Entry point, this starts the OAuth workflox
		*/
		case 'Authenticate';
			$callbackURL = isset($_REQUEST['callbackURL']) ? $_REQUEST['callbackURL'] : '' ;
			$objFMDataAPIOAuthConnector = new FMDataAPIOAuthConnector(SERVER);
			$callbackURL = $objFMDataAPIOAuthConnector->SetApplicationCallbackURL($callbackURL);
			// Display a list of OAuthListProviders; These are the OAuth providers configured in FileMAker Server
			header ( 'Location:../oAuthConnector/OAuthListProviders.php');
			break;
		
		/**
		*	After a user chooses a OAuth provider, this action first fetches a Request Id from FileMaker Server and 
		*	then redirects to the  OAuthprovider for the Authorisation grant request.
		*/
		case 'GetRequestId';
			$provider = isset($_REQUEST['provider']) ? $_REQUEST['provider'] : 'Google' ;
			$trackingID = isset($_REQUEST['trackingID']) ? $_REQUEST['trackingID'] : '' ;
			$returnURL =  'https://' . SERVER . $_SERVER['PHP_SELF'] ;  //'https://' . SERVER . $currentDirectory . '/oAuthDispatcher.php?action=GetIdentifier'
			$objFMDataAPIOAuthConnector = new FMDataAPIOAuthConnector(SERVER);
			$authURL = $objFMDataAPIOAuthConnector->GetRequestId($returnURL,$provider,$trackingID);
			$objFMDataAPIOAuthConnector->AuthenticateWithOAuthProvider($authURL);
			
			break;
		
		/**
		*	After the Resource Owner (i.e. the end user) grants authorisation and is authenticated, the OAuath first 
		*	redirects to FileMAker Server and then FileMaker Server redirects to the OAuth dispatcher here so we can fetch the Identifier.
		*/
		case 'GetIdentifier';
			$identifier = $_REQUEST['identifier'] ;
			$objFMDataAPIOAuthConnector = new FMDataAPIOAuthConnector(SERVER);
			$objFMDataAPIOAuthConnector->StoreIdentifier($identifier);
			$callbackURL = $objFMDataAPIOAuthConnector->GetApplicationCallbackURL();
			
			header('Location:' . $callbackURL);
			
			break;
		
	}
	
	
	
