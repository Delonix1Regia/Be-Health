<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Register</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

	<div class="middle-box text-center loginscreen   animated fadeInDown">
		<div>
			<div>

				<h1 class="logo-name"></h1>

			</div>
			<h3>Register</h3>
			<p>Create account</p>
			<form class="m-t" role="form" action="aksiregister.php" method="POST">
				<div class="form-group">
					<select class="form-control" name="level" required>
						<option value="Admin">Admin</option>
						<option value="User">User</option>
						<option value="Nutrisionist">Nutrisionist</option>
					</select>
				</div>
				<div class="form-group">
					<input type="text" name="namalengkap" class="form-control" placeholder="Nama Lengkap" required="">
				</div>
				<div class="form-group">
					<input type="email" name="email" class="form-control" placeholder="Email" required="">
				</div>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username" required="">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password" required="">
				</div>
				<div class="form-group">
					<div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
				</div>
				<button type="submit" class="btn btn-primary block full-width m-b">Register</button>

				<p class="text-muted text-center"><small>Already have an account?</small></p>
				<a class="btn btn-sm btn-white btn-block" href="logininspinia.php">Login</a>
			</form>
			<p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
		</div>
	</div>

	<!-- Mainly scripts -->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="js/plugins/iCheck/icheck.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
		});
	</script>
</body>

</html>