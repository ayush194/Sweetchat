<?php
include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php";

$usernameErr = $passwordErr = "";
$username = "";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function userAccess() {
  global $username, $passwordErr;
  $conn = connect();
  $query = $conn->prepare("select userid, password from users where username=?;");
  $query->bind_param("s", $username);
  $query->execute();
  $result = $query->get_result();
  //die($password);
  //$hashed_password = $result->fetch_assoc()["password"];
  $row = $result->fetch_assoc();
  if (password_verify($_POST["password"], $row["password"])) {
    //die("access granted");
    $_SESSION["userid"] = $row["userid"];
    $_SESSION["username"] = $username;
    header("Location: /home/home");
    die();
  } else {
    session_destroy();
    $passwordErr = "Password Incorrect";
    //die("access denied");
  }
  $conn->close();
}

function validateData() {
  global $usernameErr, $passwordErr, $username;
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/^[A-Za-z0-9_]+\$/",$username)) {
      $usernameErr = "Username Incorrect"; 
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  }

  if (empty($usernameErr) and empty($passwordErr)) {
    //verify them against database;
    $user_access = userAccess();
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	validateData();
	/*
	global $firstname, $lastname, $email, $username, $password, $gender, $firstnameErr, $lastnameErr, $emailErr, $usernameErr, $passwordErr, $genderErr;
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$email = $_POST["email"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	insertData();
	*/
}


?>