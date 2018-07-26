<?php
//session remembrance check here

include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php";

$firstnameErr = $lastnameErr = $emailErr = $usernameErr = $passwordErr = $genderErr = "";
$firstname = $lastname = $email = $username = $password = $gender = "";

// define variables and set to empty values
function verifyUsername($username) {
  $conn = connect();
  //prepare and bind
  if (!($query = $conn->prepare("select username from users where username=(?);"))) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  }
  if (!$query->bind_param("s", $username)) {
    die("Binding output parameters failed: (" . $query->errno . ") " . $query->error);
  }
  if (!$query->execute()) {
    die("Execute failed: (" . $query->errno . ") " . $query->error);
  }
  if (!$result = $query->get_result()) {
    die("Getting result set failed: (" . $query->errno . ") " . $query->error);
  }
  if ($result->num_rows > 0) {
    return "unavailable";
  } else {
    return "available";
  }
  $conn->close();
}

function verifyEmail($email) {
  $conn = connect();
  //prepare and bind
  if (!($query = $conn->prepare("select email from users where email=(?);"))) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  }
  if (!$query->bind_param("s", $email)) {
    die("Binding output parameters failed: (" . $query->errno . ") " . $query->error);
  }
  if (!$query->execute()) {
    die("Execute failed: (" . $query->errno . ") " . $query->error);
  }
  if (!$result = $query->get_result()) {
    die("Getting result set failed: (" . $query->errno . ") " . $query->error);
  }
  if ($result->num_rows > 0) {
    return "unavailable";
  } else {
    return "available";
  }
  $conn->close();
}

function insertData() {
  global $firstname, $lastname, $email, $username, $password, $gender, $firstnameErr, $lastnameErr, $emailErr, $usernameErr, $passwordErr, $genderErr;
  $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
  $conn = connect();
  if (!($query = $conn->prepare("insert into users (firstname, lastname, email, username, password) values (?, ?, ?, ?, ?);"))) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  }
  if (!$query->bind_param("sssss", $firstname, $lastname, $email, $username, $hashedpassword))  {
    die("Binding output parameters failed: (" . $query->errno . ") " . $query->error);
  }
  if (!$query->execute()) {
    die("Execute failed: (" . $query->errno . ") " . $query->error);
  }
  $conn->close();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function validateData() {
  global $firstname, $lastname, $email, $username, $password, $gender, $firstnameErr, $lastnameErr, $emailErr, $usernameErr, $passwordErr, $genderErr;
  if (empty($_POST["firstname"])) {
    $firstnameErr = "First Name is required";
  } else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white spaces allowed"; 
    }
  }
  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last Name is required";
  } else {
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lastnameErr = "Only letters and white spaces allowed"; 
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if email is already being used by another user
    if (verifyEmail($email) != "available") {
      $emailErr = "Email already in use";
    }
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
    
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if username is already being used by another user
    if (verifyUsername($username) != "available") {
      $usernameErr = "Username already in use";
    }
    // check if username matches the specified pattern)
    if (!preg_match("/^[A-Za-z0-9_]+\$/",$username)) {
      $usernameErr = "Invalid Username"; 
    }
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else if (strlen($_POST["password"]) < 8) {
    $passwordErr = "Password should be at least 8 characters";
  } else {
    $password = $_POST["password"];
  }

  //die("/" . $firstnameErr . "/" . $lastnameErr . "/". $emailErr . "/". $usernameErr . "/" . $passwordErr . "/" . $genderErr . "/");
  if (empty($firstnameErr)  and empty($lastnameErr) and empty($emailErr) and empty($usernameErr) and empty($passwordErr) and empty($genderErr)) {
    insertData();
  } else {

  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["username_check"])) {
    echo verifyUsername($_POST["username"]);
  } else if (isset($_POST["email_check"])) {
    echo verifyEmail($_POST["email"]);
  } else {
    validateData();
    header("Location: /login/login");
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
}


?>