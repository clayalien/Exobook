<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$name?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

</head>
<body>

<div id="container">
	<h1><?=$name?></h1>

	<div id="body">
		<img src="https://github.com/hannorein/open_exoplanet_catalogue/raw/master/data_images/<?=$image?>.iPhone.png">
		<p>
			<?=$imagedescription?>
		</p>
		<p>
			<?=$description?>
		</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>