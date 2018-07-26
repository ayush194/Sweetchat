<?php
function validateChat($chatid) {
	$conn = connect();
	$query = $conn->prepare("select chatusers.userid from chatusers where chatusers.userid=(?) and chatusers.chatid=(?);");
	$query->bind_param("ii", $_SESSION["userid"], $chatid);
	$query->execute();
	$result = $query->get_result();
	if ($result->num_rows > 0) { return true; }
	else { return false; }
}

?>