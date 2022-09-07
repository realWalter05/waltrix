<section id="register-login" class="mt-5 p-5 d-flex flex text-white row" style="width: 82vw;">
	<form class="p-5 col" action="/includes/php/register_user.php" method="GET">
		<h2 class="text-center display-5">Register</h2>
		<?php 
			if (isset($_GET["register-msg"])) {
				$msg = $_GET["register-msg"];
				if ($msg == "empty_values") {
					echo("<p class='text-danger text-center'>Vyplňte prosím všechna pole</p>");
				} else if ($msg == "system_err") {
					echo("<p class='text-danger text-center'>Omlouváme se nastala systémová chyba. Zkuste to prosím znovu později</p>");
				}
			}
		?>
		<div class="form-group mb-2 m-auto">
    		<label for="register-username">Username</label>
    		<input type="text" class="form-control" id="register-username" name="reg-username" placeholder="Joe Who..." value="<?php echo((isset($_GET["reg-username"]) ? htmlspecialchars($_GET["reg-username"]) : '')); ?>">
  		</div>	
		<div class="form-group mb-2 m-auto">
    		<label for="register-email">Email</label>
    		<input type="email" class="form-control" id="register-email" name="reg-email" placeholder="mamajoe@gmail.com etc." value="<?php echo((isset($_GET["reg-email"]) ? htmlspecialchars($_GET["reg-email"]) : '')); ?>">
  		</div>		
		<div class="form-group mb-2 m-auto">
    		<label for="register-password">Password</label>
    		<input type="password" class="form-control" id="register-password" name="reg-password" placeholder="abc123...">
			<input type="submit" name="registration" value="Submit registration" class="mt-3 btn btn-light form-control">
  		</div>	
	</form>	
	<form class="p-5 col" action="/includes/php/login_user.php" method="GET">
		<h2 class="text-center display-5">Login</h2>
		<?php 
			if (isset($_GET["login-msg"])) {
				$msg = $_GET["login-msg"];
				if ($msg == "empty_values") {
					echo("<p class='text-danger text-center'>Vyplňte prosím všechna pole</p>");
				} else if ($msg == "system_err") {
					echo("<p class='text-danger text-center'>Omlouváme se nastala systémová chyba. Zkuste to prosím znovu později</p>");
				} else if ($msg == "wrong_pwd") {
					echo("<p class='text-danger text-center'>Vaše heslo není správné.</p>");
				}
			}
		?>
		<div class="form-group mb-2 m-auto">
    		<label for="login-email">Email</label>
    		<input type="email" class="form-control" id="login-email" name="log-email" placeholder="Write your email" value="<?php echo((isset($_GET["log-email"]) ? htmlspecialchars($_GET["log-email"]) : '')); ?>"/>
  		</div>	
		<div class="form-group mb-2 m-auto">
    		<label for="login-password">Password</label>
    		<input type="password" class="form-control" id="login-password" name="log-password" placeholder="aBc123">
			<input type="submit" name="login" value="Login to Waltrix" class="mt-3 btn btn-light form-control">
  		</div>	
	</form>			
</section>
