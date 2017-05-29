<?php
	require_once ( '../../Configuration.php') ;
	
	$url = "https://" . SERVER . "/fmws/oauthproviderinfo";
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch) ;
	curl_close($ch) ;
	
	//print_r($output);
	
	$arrProviders = json_decode ( $output , true);
	
	//print_r($arrProviders ) ; exit();
	
	
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<style type="text/css">
		h1 {
			font-family: Helvetica, Arial;
			text-align: center;
		}
		body{
			font-family: Helvetica, Arial;
		}
	</style>
		<title>List Of OAuth Providers</title>
	</head>
	<body>
	<h1>Log in to Jeroen's Test Application</h1>
	<div style="width: 100%;display: block; text-align:center; ">
	<?php
		foreach($arrProviders['data']['Provider'] as $arrProviderDetails) {
			?>
			<a href="OAuthCallProvider.php?provider=<?php echo $arrProviderDetails['Name']?>"><img src="Resources/<?php echo $arrProviderDetails['Name']?>.png" style="width: 156px; height: 38px" /></a>
			<?php
		}  
	?>
	<div>

	
	

	
	
	</body>
	</html>
