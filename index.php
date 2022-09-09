<?php
session_start();
require_once './includes/php/tmdb_api.php';
require_once './includes/php/database.php';

?>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>Waltrix</title>
		<meta name="description" content="Hledáte stránku, kde koukat na seriály. Nehledejte. Už jí máte. A to bez reklam a s bezkonkurenčními funkcemi. Waltrix - better than *etflix :)">
		<meta name="keywords" content="Seriály, najseriály, seriály zdarma, filmy zdarma, sledujuserialy, serialy zdarma bez reklam, Waltrix">
		<meta name="author" content="Walter">
		<link rel="icon" type="image/x-icon" href="./img/logo.png">
    	<link href="./includes/main.css" rel="stylesheet"/>
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>		
		<script src="./includes/main.js"></script>
    	<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<section id="main-section">
			<?php 	
			include("./includes/php/nav.php"); 

			$p = "home";
			if (isset($_GET["p"])) {
				# We got the page
				if(preg_match('/^[a-zA-Z0-9]+$/', $_GET["p"])) {
					# Page has right letters
					if (file_exists("./includes/pages/".$_GET["p"].".php")) {
						# Page exists
						$p = $_GET["p"];
					}
				}
			}

			include("./includes/pages/$p.php");
			?>
		</section>
	</body>
</html>
