<?php
function getFriends($result) {
  $resp = '';
  while ($row = $result->fetch_assoc()) {
    $conn = connect();
    //$query = $conn->prepare("select type from status inner join (select statusid from relationships where userid_1=(?) and userid_2=(?)) as t on status.statusid=t.statusid;");
    $query = $conn->prepare("select statusid from relationships where userid_1=(?) and userid_2=(?);");
    $maxuserid = $row["userid"] > $_SESSION["userid"] ? $row["userid"] : $_SESSION["userid"];
    $minuserid = $row["userid"] < $_SESSION["userid"] ? $row["userid"] : $_SESSION["userid"];
    $query->bind_param("ii", $minuserid, $maxuserid);
    $query->execute();
    $result2 = $query->get_result();
    $conn->close();

    $card_info = array();
    $card_info["username"] = $row["username"];
    $card_info["name"] = $row["firstname"] . ' ' . $row["lastname"];
    $card_info["userid_1"] = $minuserid;
    $card_info["userid_2"] = $maxuserid;
    $card_info["userid_1_is_you"] = ($card_info["userid_1"] == $_SESSION["userid"]);

    if ($result2->num_rows == 0) {
      $card_info["statusid"] = -1;
      $card_info["background"] = 'bg-light';
      $card_info["text"] = $card_info["name"] . ' is not currently your friend. You can start by sending him/her a friend request.';
      $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .','. ($card_info["userid_1_is_you"] ? '1' : '2') .')', 'btn-primary', 'Add Friend');
    } else {
      $card_info["statusid"] = $result2->fetch_assoc()["statusid"];
      switch ($card_info["statusid"]) {
        case 1:
        case 2:
          if (($card_info["statusid"] == 1 && $card_info["userid_1_is_you"]) || ($card_info["statusid"] == 2 && !$card_info["userid_1_is_you"])) {
            $card_info["background"] = 'bg-warning';
            $card_info["text"] = 'You have sent a request to '. $card_info["name"] .'.';
            //button text, button color, button onclick
            $card_info["buttons"][] = array('', 'btn-primary disabled', 'Pending');
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn-primary', 'Cancel');
          } else {
            $card_info["background"] = 'border-warning';
            $card_info["text"] = 'You have received a request from '. $card_info["name"] .'.';
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"]. ','. $card_info["statusid"] .',3)', 'btn-primary', 'Accept');
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn-primary', 'Reject');
          }
          break;
        case 3:
          $card_info["background"] = 'border-primary';
          $card_info["text"] = 'You and ' . $card_info["name"] . ' are friends.';
          $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn-primary', 'Unfriend');
          $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"]. ','. $card_info["statusid"] .','. ($card_info["userid_1_is_you"] ? '4' : '5') .')', 'btn-danger', 'Block');
          break;
        case 4:
        case 5:
          if (($card_info["statusid"] == 4 && $card_info["userid_1_is_you"]) || ($card_info["statusid"] == 5 && !$card_info["userid_1_is_you"])) {
            $card_info["background"] = 'border-danger';
            $card_info["text"] = 'You have blocked '. $card_info["name"] .'.';
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn-primary', 'Unfriend');
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',3)', 'btn-danger', 'Unblock');
          } else {
            $card_info["background"] = 'bg-danger';
            $card_info["text"] = 'You have been blocked from '. $card_info["name"] .'.';
            $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn btn-primary', 'Unfriend');
            $card_info["buttons"][] = array('', 'btn-danger disabled', 'Blocked');
          }
          break;
        case 6:
          $card_info["background"] = 'bg-danger border-danger';
          $card_info["text"] = 'You and '. $card_info["name"] .' have blocked each other.';
          $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"].','. $card_info["statusid"] .',-1)', 'btn-primary', 'Unfriend');
          $card_info["buttons"][] = array('changeStatus('.$card_info["userid_1"].','.$card_info["userid_2"]. ','. $card_info["statusid"] .','. ($card_info["userid_1_is_you"] ? '5' : '4') .')', 'btn-primary', 'Unblock');
          $card_info["buttons"][] = array('', 'btn-danger disabled', 'Blocked');
          break;
      }
    }
    $resp .= 
    '<div class="card mx-auto mb-4 '. $card_info["background"] .'" style="width: 18rem;">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">@'. $card_info["username"] .'</h5>
        <p class="card-text">'. $card_info["text"] .'</p>
        <div class="d-flex mt-auto flex-column">';
        foreach ($card_info["buttons"] as $button) {
          $resp .= '<a onclick="'. $button[0] .'" href="#" class="mb-2 btn '. $button[1] .'">'. $button[2] .'</a>';
        }
    $resp .=
        '</div>
      </div>
    </div>';
  }
  return $resp;
}
?>