<?php include "submit.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
  <script src="./validate.js"></script>
  <title>SweetChat | Signup</title>
</head>

<body>
  <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/header.php";
  ?>
  <center>
  	<form class="col-sm-6 col-10 needs-validation" method="post" action="">
  		<div class="row">
  			<div class="col-sm-6 col-12">
  				<input class="form-control" placeholder="First Name" onfocusout="validateName(this)" type="text" name="firstname" value="<?php echo $firstname;?>" required>
          <div class="invalid-feedback">Not a Valid Name!</div>
        </div>
        <div class="col-sm-6 col-12">
  				<input class="form-control" placeholder="Last Name" onfocusout="validateName(this)" type="text" name="lastname" value="<?php echo $lastname;?>" required>
          <div class="invalid-feedback">Not a Valid Name!</div>
  			</div>
  		</div>
      <br>
      <div class="row">
        <div class="col">
          <input class="form-control" placeholder="E-Mail" onfocusout="validateEmail(this)" type="text" name="email" value="<?php echo $email;?>" required>
          <div class="invalid-feedback">Email invalid or already in use!</div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-6 col-12">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text">@</div>
            </div>
            <input class="form-control" placeholder="Username" onfocusout="validateUser(this)" type="username" name="username" value="<?php echo $username;?>" required>
            <div class="invalid-feedback">Username invalid or already in use! Only use alpanumerics and underscores!</div>
          </div>
        </div>
        <div class="col-sm-6 col-12">
          <input class="form-control" placeholder="Password" onfocusout="validatePass(this)" type="password" name="password" required>
          <div class="invalid-feedback">Your password must be at least 8 characters!</div>              
        </div>
      </div>
      <br>
      <center>
      <div class="row">
        <div class="col" class="">
          <input class="form-check-input" type="radio" name="gender" value="female" required>
          <label class="form-check-label" for="inlineRadio1">Female</label>
        </div>
        <div class="col">
          <input class="form-check-input" type="radio" name="gender" value="male" required>
          <label class="form-check-label" for="inlineRadio1">Male</label>
        </div>
      </div>
      </center>
      <br>
      <center>
        <input class="btn btn-primary" type="submit" id="test" name="submit" value="Sign Up">
      </center>
      <br><br>
      <h7>Already have an account? <a href="/login/login">Log In</a></h7>
  	</form>
  </center>
  <br><br><br><br>

  <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/footer.html";
  ?>

</body>
<script>

/*
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
*/

</script>
<?php
echo "<script>";
if (!empty($firstname)) {
  echo "validateName(document.getElementsByName('firstname')[0]);";
}
if (!empty($lastname)) {
  echo "validateName(document.getElementsByName('lastname')[0]);";
}
if (!empty($email)) {
  echo "validateEmail(document.getElementsByName('email')[0]);";
}
if (!empty($username)) {
  echo "validateUser(document.getElementsByName('username')[0]);";
}
echo "</script>";
?>
</html>