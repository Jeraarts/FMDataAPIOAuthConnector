<?php
	use  ClickWorks\FMDataAPIOAuthConnector;
	
	require_once ( '../Configuration.php') ;
	require_once ( 'Class.FMDataAPIOAuthConnector.php') ;
	
	$objFMDataAPIOAuthConnector = new FMDataAPIOAuthConnector(SERVER);
	
	$arrProviders = $objFMDataAPIOAuthConnector->ListProviders();	
	//print_r($arrProviders ) ; exit();
	?><!DOCTYPE html>
<html>
	<head>
		<style type="text/css">
			h1 {
				font-family: Helvetica, Arial;text-align: center;
			}
			body {
				font-family: Helvetica, Arial;
			}
			div.button-links {
				width: 100%; display: block; text-align:center; 
			}
			a.button_link{
				text-decoration: none;
			}
		</style>
		<title>List Of OAuth Providers</title>
	</head>
	<body>
		<h1>Log in to the Test Application</h1>
		<div class="button-links">
			<?php
				foreach($arrProviders['data']['Provider'] as $arrProviderDetails) {
			?>
				<a class='button_link' href="OAuthDispatcher.php?action=GetRequestId&provider=<?php echo $arrProviderDetails['Name']?>">
					<img src="Resources/<?php echo $arrProviderDetails['Name']?>.png" style="width: 156px; height: 38px" />
				</a>
			<?php
			}  
			?>
		<div>
	</body>
</html>