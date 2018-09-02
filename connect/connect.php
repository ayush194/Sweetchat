<?php
function connect() {
	//$conn = new mysqli("localhost", "root", "crap-bag", "sweetchat");
	//For deploying on heroku
	$conn = new mysqli("us-cdbr-iron-east-01.cleardb.net", "bb6c241fee9ae2", "15d3b257", "heroku_ffb51ce9427a989");
  //check for connection error
  if ($conn->connect_error) {
    die("Cannot connect to database : " . $conn->connect_error);
  }
  return $conn;
}
?>