<?php require_once('layout/header.php'); ?>
<?php
$error = ''; // Initially we assume there is no query string

// Check if there is a query string, then retrive it to show the error.
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
if (isset($queries) && count($queries) > 0) {
	// Check if there is an error then set it.
	$error = $queries['error'];
}

?>
<div class="container mt-5 p-5">
	<div class="card">
		<div class="card-body">
			<h2 class="text-center">Welcome to Fork & Spoon</h2>
			<?php
			if ($error == 'invalid') {
				echo '<div class="bg-danger mt-4 mb-4 p-2">Invalid username or password</div>';
			}
			?>
			<!-- <?php
			// if ($error == 'disabled') {
			// 	echo '<div class="bg-warning mt-4 mb-4 p-2">Your account is disabled. Please contact quality control team</div>';
			// }
			?> -->
			<?php
			if ($error == 'empty') {
				echo '<div class="bg-warning mt-4 mb-4 p-2">Please enter all fields</div>';
			}
			?>
			<!-- <?php
			// if ($error == 'pending') {
			// 	echo '<div class="bg-warning mt-4 mb-4 p-2">Your account is not activated yet</div>';
			// }
			?> -->
		<form autocomplete="off" method="POST" action="login-service.php" id="login-frm">
				<div class="form-group">
					<label for="" class="control-label">Email</label>
					<input autocomplete="email" type="email" required name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="control-label">Password</label>
					<input autocomplete="password" type="password" required name="password" class="form-control">
					<small><a href="/fork&spoon/signup.php" id="new_account">Create New Account</a></small>
				</div>
				<button class="button btn btn-block btn-primary">Login</button>
			</form>
				<!-- <button class="loginbtn" value="logibtn">
				<label for="logibtn" class="login">Login</label><br>
				</button> -->
				
			
		</div>
	</div>
</div>

<?php require_once('layout/footer.php') ?>