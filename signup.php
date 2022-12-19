<?php require_once('layout/header.php'); ?>
<div class="container mt-5 p-5">
	<div class="card">
		<div class="card-header">
			<h2 class="text-center">Signup</h2>
		</div>
		<div class="card-body">
			<form method="POST" action="signup-service.php" id="signup-frm" >
				<div class="form-group">
					<label for="" class="control-label">Name</label>
					<input type="text" name="name" required="" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="control-label">Email</label>
					<input id="email" type="email" name="email" required="" class="form-control">
					<div id="emailValidation" class="text-danger">Email already exists</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Password</label>
					<input id="password" type="password" name="password" required="" class="form-control">
					<div id="pass" class="text-danger">Password Must Be Atleast 8 Characters</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Confirm Password</label>
					<input id="confirmPassword" type="password" name="confirmPassword" required="" class="form-control">
					<div id="confirmPasswordError" class="text-danger">Password does not match</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Phone Number</label>
					<input type="text" id="phonenumber" name="phonenumber" required="" class="form-control">
				</div>
				<hr />
				<button class="button btn btn-primary btn-block">Create</button>
			</form>
		</div>
	</div>
</div>

<script>
	function onlyNumbers(str) {
		return /^[0-9]+$/.test(str);
	}

	let canSubmit = true;
	// Initially hide the confirm password error message (becuase form is empty)
	$('#confirmPasswordError').hide();
	$('#emailValidation').hide();
	$('#pass').hide();

	// Handle the submit
	$('#signup-frm').submit(function(e) {
		// Check if submission is prevented due to invalid data
		if (!canSubmit) {
			e.preventDefault();
		}
		// Get the password, and confirmPassword values
		const password = $('#password').val();
		const confirmPassword = $('#confirmPassword').val();
		// Check if password's don't match
		if (password != confirmPassword) {
			// Prevent the default submit action
			e.preventDefault();
			// Show the error message
			$('#confirmPasswordError').show();
		} else {
			$('#confirmPasswordError').hide();
		}
		if(password.length<8) {
			e.preventDefault();
			$('#pass').show();
		} else {
            $('#pass').hide();
		}
	});
	$('#email').keyup(function(e) {
		const ajaxData = 'email=' + e.target.value;
		$.ajax({
			url: 'user-service/validate-email.php',
			method: "POST",
			data: ajaxData,
			success: function(response) {
				$('#emailValidation').hide();
				canSubmit = true;
			},
			error: function(err) {
				$('#emailValidation').show();
				canSubmit = false;
			}
		})
	});

	

</script>
<?php require_once('layout/footer.php') ?>