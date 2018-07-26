<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["username_check"])) {
    //reqest for checking username against database
    //establish connection
    $conn = new mysqli("localhost", "root", "starfish12345", "sweetchat");
    //check for connection error
    if ($conn->connect_error) {
      die("Cannot connect to database : " . $conn->connect_error);
    } else {
      $username = $_POST["username"];
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
        echo "taken";
      } else {
        echo "available";
      }
    }
    $conn->close();
  } else if (isset($_POST["email_check"])) {
    //reqest for checking email against database
    //establish connection
    $conn = new mysqli("localhost", "root", "starfish12345", "sweetchat");
    //check for connection error
    if ($conn->connect_error) {
      die("Cannot connect to database : " . $conn->connect_error);
    } else {
      $email = $_POST["email"];
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
        echo "taken";
      } else {
        echo "available";
      }
    }
    $conn->close();
  }
  exit();
}
?>