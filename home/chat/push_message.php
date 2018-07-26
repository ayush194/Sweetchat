<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/home/chat/fetch_message_cards.php" ?>

<?php

function pushMessage($chatid, $userid, $text) {
	$conn = connect();
  $text = removeMarkup($text);
  //$text = $conn->real_escape_string($text);
  $query = $conn->prepare("insert into messages (text, chatid, userid) values(?, ?, ?);");
  $query->bind_param("sii", $text, $chatid, $userid);
  $query->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  pushMessage($_POST["chatid"], $_SESSION["userid"], $_POST["text"]);
  
  /*
  $conn = connect();
  $query = $conn->prepare("select color from chats where chatid=(?);");
  $query->bind_param("i", $_POST["chatid"]);
  $query->execute();

  $card_info["color"] = $query->get_result()->fetch_assoc()["color"];
  $card_info["userid_is_you"] = true;
  $card_info["username"] = $_SESSION["username"];
  $card_info["senton"] = time();
  $card_info["text"] = $_POST["text"];
  echo fetchMessageCard($card_info);
  echo "Message Sent!";
  */
}

function removeMarkup($str) {
  $str = preg_replace('/<br\s*[\/]?>/i', '', $str);
  $str = preg_replace('/<div\s*\/>/i', '\n', $str);
  $str = preg_replace('/<div\s*>([^<]*)<\/\s*div>/i', '\n${1}', $str);
  $str = htmlspecialchars($str);
  return $str;
}

?>