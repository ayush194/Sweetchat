<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
	<link rel="icon" href="/Icons/favicon.png" />
	<title>SweetChat</title>
</head>

<body>
	<div class="logo-text container-fluid jumbotron">
		<div>
			<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/logo.html"; ?>
		</div>
		<div style="font-size:10px;">Find your peers and chat sweet :)</div>
	</div>
	<br><br><br>
	<center>
		<a href="/login/login" class="btn btn-outline-secondary">Login</a>
		<a href="/signup/signup" class="btn btn-outline-secondary">Signup</a>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/footer.html"; ?>
</body>
</html>