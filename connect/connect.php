<?php
function connect() {
	$conn = new mysqli("localhost", "root", "starfish12345", "sweetchat");
  //check for connection error
  if ($conn->connect_error) {
    die("Cannot connect to database : " . $conn->connect_error);
  }
  return $conn;
}
?>