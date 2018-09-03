<?php
  session_start();
  if (isset($_SESSION["username"])) {
    header("Location: https://sweet-chat.herokuapp.com/home/home");
    die();
  }
  include "attempt.php";
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
	<title>SweetChat | Login</title>
</head>

<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/header.php"; ?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<center>
			<input class="form-control col-10 col-sm-3" placeholder="Username" type="username" name="username" value="<?php echo $username; ?>" required><br>
			<input class="form-control col-10 col-sm-3" placeholder="Password" type="password" name="password" required>
      <label><?php echo $usernameErr . $passwordErr; ?></label><br>
			<input class="btn btn-primary" type="submit" value="Log In">
		</center>
	</form>
	<br><br>
	<center>
		<h7>Don't have an account already? <a href="/signup/signup">Sign Up</a></h7>
	</center>

	<br><br><br>

  <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/footer.html"; ?>

</body>
</html>