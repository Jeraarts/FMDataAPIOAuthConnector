<?php
	echo "<h1>Redirect page</h1>" ;
	
	echo "<br/>\n";
	
	//print_r(getallheaders());
	
	$identifier = $_REQUEST['identifier'] ;
	$file = fopen('../../Storage/Identifier.txt','w');
	$result = fwrite($file, $identifier);
	$result = fclose($file);
	
	$fileCallback = fopen('../../Storage/Callback.txt','r');
	$callbackURL = fread ( $fileCallback, filesize('../../Storage/Callback.txt') );
	
	//echo "Identifier: " . $identifier;
	
	header('location:' . $callbackURL);