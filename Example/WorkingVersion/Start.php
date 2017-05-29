<?php
	require_once('../../Configuration.php');
	
	$callback = 'http://clickserver23.clickworks.eu/FMS16_REST_API_TEST/Example/WorkingVersion/GetCompaniesList.php';
	
	$file = fopen('../../storage/Callback.txt','w');
	$result = fwrite($file, $callback);
	$result = fclose($file);
	
	header ( 'Location:../../oAuthConnector/WorkingVersion/OAuthListProvidersProc.php');
