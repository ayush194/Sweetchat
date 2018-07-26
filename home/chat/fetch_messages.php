<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/home/chat/fetch_message_cards.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/home/chat/validate_chat.php" ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //echo "hello";
  $response = fetchMessages($_POST["chatid"], $_POST["lastupdated"]);
  header('Content-type: application/json');
  echo json_encode($response);
}

function fetchMessages($chatid, $time) {
	$conn = connect();
	$query = $conn->prepare("select chats.color as color from chats where chats.chatid=(?);");
	$query->bind_param("i", $chatid);
	$query->execute();
	$card_info["color"] = $query->get_result()->fetch_assoc()["color"];
	$query = $conn->prepare("select t.senton as senton, t.userid as userid, users.username as username, users.firstname as firstname, users.lastname as lastname, t.text as text from (select messages.senton as senton, messages.userid as userid, messages.text as text from messages where messages.chatid=(?) and messages.senton>(?)) as t inner join users on t.userid=users.userid order by t.senton;");
	$query->bind_param("is", $chatid, $time);
	$query->execute();
	$result = $query->get_result();

  $resp["cards"] = '';
  $resp["timestamp"] = '';
	while ($row = $result->fetch_assoc()) {
		$card_info["username"] = $row["username"];
		//$card_info["text"] = nl2br(stripcslashes($row["text"]));
    $card_info["text"] = addMarkup($row["text"]);
		$card_info["senton"] = strtotime($row["senton"]);
		$card_info["userid_is_you"] = ($row["userid"] == $_SESSION["userid"]);
    $resp["cards"] .= fetchMessageCard($card_info);
    $resp["timestamp"] = $row["senton"];
	}
  $conn->close();
  return $resp;
}

function addMarkup($str) {
  $mtext = "";
  $flag = true;
  $parts = preg_split('/\\\n/', stripcslashes($str));
  foreach ($parts as $part) {
    if ($flag) { $mtext = $part . "<div>"; $flag = false; }
    else { $mtext = $part . "</div><div>"; }
  }
  $mtext .= '</div>';
  return $mtext;
}

?>