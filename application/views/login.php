<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url();?>public/js/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>public/css/login/styles.css">
</head>

<body>

<script type="text/javascript">

	var validateRegistrationForm
	$(document).ready(function() {
		validateRegistrationForm = $('#register-form').validate({
			rules: {
				usernameReg: {
					required: true,
					minlength: 3,
					remote: {
						url: "<?php echo base_url(ROUTES::IS_UNIQUE_USERNAME_AJAX);?>",
						type: "post"
					}
				},
				email: {
					required: true,
					email: true
				},
				passwordReg: {
					required: true,
					minlength: 3
				},
				confirm_password: {
					required: true,
					equalTo: "#passwordReg"
				}
			},
			messages: {
				usernameReg: {
					required: "username can't be blank",
					minlength: "Your username must consist of at least 3 characters"
				},	
				email: {
					required: "email can't be blank",
					email: "Enter a valid email"
				},
				passwordReg: {
					required: "password can't be blank",
					minlength: "Your password must consist of at least 2 characters"
				},
				confirm_password: {
					required: "confirm password can't be blank",
					equalTo: "Please enter the same password as above"
				}
			}
		});
		clearRegistrationForm();
	});

	function clearRegistrationForm() {
		$('#usernameReg').val('');
		$('#email').val('');
		$('#passwordReg').val('');
		$('#confirm_password').val('');
		validateRegistrationForm.resetForm();
	}

	function showTransactionMessage(element, type, message) {
		var div = document.createElement('div');
		div.className = 'alert alert-dismissible';
		div.role = 'alert';
		div.innerHTML = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		
		switch(type) {
			case "success":
				div.classList.add('alert-success');
				break;
			case "failed": 
				div.classList.add('alert-danger');
				break;
		}

		var msg = document.createElement('div');
		msg.className = 'msg-text';
		msg.innerHTML = message;
		div.appendChild(msg);
		element.empty();
		element.append(div);
	}

    function register() {
		if($('#register-form').valid()) {
			var username = $('#usernameReg').val();
			var email = $('#email').val();
			var password = $('#passwordReg').val();

			var URL = '<?php echo base_url(ROUTES::USER_REGISTER);?>';
			$.post(URL, {'username': username, 'email': email, 'password': password}, function(data) {
				clearRegistrationForm();
				
				console.log(JSON.stringify(data));
				
				var result = JSON.parse(data);
				showTransactionMessage($('#alertMessage'), result.ret, result.message);
				
			})
		}	
    }

</script>

<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">

                        <section id="alertMessage"></section>

						 <?php  
                        if(isset($error)) {
                            ?>
                        <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $error; ?>
                        </div>
                        <?php  
                        }
                        ?>
                                
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="<?php echo base_url(ROUTES::USER_LOGIN);?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="usernameReg" id="usernameReg" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="passwordReg" id="passwordReg" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="confirm_password" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<button type="button" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" onclick="register()">Register</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="<?php echo base_url();?>public/js/login.js"></script>