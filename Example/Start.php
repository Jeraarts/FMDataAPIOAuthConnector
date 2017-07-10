<?php
	// This is the starting point for a custom web application
	
	// Application Callback URL to return to, after authentication and authorisation
	$callbackURL = 'http://someserver.yourdomain.org/FMS16_REST_API_TEST/Example/GetCompaniesList.php';
	
	// Redirect to start the OAuth workfow
	header ( 'Location:../oAuthConnector/OAuthDispatcher.php?action=Authenticate&callbackURL=' . $callbackURL);
