<?php
function connect() {
	/*
	$conn = new mysqli("localhost", "root", "starfish12345", "sweetchat");
  //check for connection error
  if ($conn->connect_error) {
    die("Cannot connect to database : " . $conn->connect_error);
  }
	*/
  //For deploying on heroku
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$conn = new mysqli($server, $username, $password, $db);
  return $conn;
}
?>