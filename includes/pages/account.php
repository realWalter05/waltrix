<section id="register-login" class="mt-5 p-5 text-white">
	<section class="p-5 w-50 m-auto" action="/includes/php/register_user.php" method="GET">
		<h2 class="text-center display-5">Your account</h2>
		<div class="form-group mb-2">
    		<label for="register-username">Username</label>
    		<input type="text" class="form-control" id="register-username" readonly value="<?php echo($_SESSION["user"]["username"]); ?>">
  		</div>	
		<div class="form-group mb-2">
    		<label for="register-email">Email</label>
    		<input type="email" class="form-control" id="register-email" readonly value="<?php echo($_SESSION["user"]["email"]); ?>">
  		</div>		
		<div class="row">
			<a class="col" href="?p=account&logout">Odhlásit se</a> 
			<a class="col" href="?p=account&reset" style="text-align: end;" href="#">Vymazat historii</a>
		<div>
	</section>	
</section>
<?php 
if (isset($_GET["logout"])) {
	session_destroy();
	setcookie("cookie_token", "", time()-3600);	
	header("Location: http://".$_SERVER['HTTP_HOST'].$formaction);
	exit;  	
}

if (isset($_GET["reset"])) {
	$conn = get_conn();
	$query = "DELETE FROM `watched_series` WHERE user_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
	if ($stmt->execute()) {
		$query = "DELETE FROM `watched_movies` WHERE user_id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
		if ($stmt->execute()) {
			$query = "DELETE FROM `watching_series` WHERE user_id=?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
			if ($stmt->execute()) {
				$query = "DELETE FROM `watching_movies` WHERE user_id=?";
				$stmt = $conn->prepare($query);
				$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
				if ($stmt->execute()) {
					header("Location: http://".$_SERVER['HTTP_HOST'].$formaction);
					exit;  			
				}					
			}			
		}					
	}	
}
?>