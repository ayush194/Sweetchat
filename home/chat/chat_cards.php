<?php

function getChatCards($result) {
  $resp = '';
	while ($row = $result->fetch_assoc()) {
    $card_info["chatid"] = $row["chatid"];
    $card_info["color"] = $row["color"];
		$card_info["created_by"] = ($_SESSION["userid"] == $row["userid"] ? 'you' : $row["firstname"] . ' ' . $row["lastname"]);
    $card_info["topic"] = $row["topic"];
    $card_info["text"] = 'Created by '. $card_info["created_by"];
    
    //obtain members of the current chatid
    $conn = connect();
    $query = $conn->prepare("select users.userid, users.username, users.firstname, users.lastname from (select chatusers.userid as userid from chatusers where chatusers.chatid=(?)) as t inner join users on t.userid=users.userid;");
    $query->bind_param("i", $card_info["chatid"]);
    $query->execute();
    $result2 = $query->get_result();
    $conn->close();
    $card_info["members"] = null;
    while ($row = $result2->fetch_assoc()) {
      $card_info["members"][] = $row["username"];
    }

		$resp .= 
	    '<div class="card mx-auto mb-4" style="border-color:'. $card_info["color"] .'; width: 18rem;">
	      <div class="card-body d-flex flex-column">
	        <h5 class="card-title">'. $card_info["topic"] .'</h5>
	        <p class="card-text">'. $card_info["text"] .'</p>
          <p class="card-text">Members :<span style="color:'. $card_info["color"] .';">';
          foreach($card_info["members"] as $member) {$resp .= ' @'. $member;}
          $resp .= '</span></p>
	        <div class="d-flex mt-auto flex-column">
          <form method="get" target="_blank" action="/home/chat/chatbox">
          <input class="form-control" style="visibility:hidden;" name="chatid" value="'. $card_info["chatid"] .'">
	        <button type="submit" class="btn" style="background-color:'. $card_info["color"] .';">SweetChat</button>
          </form>
	        </div>
	      </div>
	    </div>';
	}
  return $resp;
}

?>