<?php
function fetchMessageCard($card_info) {
  return
  '<div class="card '. ($card_info["userid_is_you"] ? 'mr-3 align-self-end' : 'ml-3 align-self-start') .'" style="width: 18rem; border-color:'. $card_info["color"] .';">
    <div class="card-body" style="text-align:'. ($card_info["userid_is_you"] ? 'right' : 'left') .';">
    <!--<h5 class="card-title">Card title</h5>-->
    <h6 class="card-subtitle mb-2 text-muted">@'. $card_info["username"] .'</h6>
    <div class="mb-3 card-text" style="white-space:pre-wrap; color:'. $card_info["color"] .';">'. $card_info["text"] .'</div>
    <h6 class="card-subtitle text-muted">'. date("j F Y g:i", $card_info["senton"]) .'</h6>
    </div>
  </div>';
}

function fetchMessageInputCard($chatid) {
	return
    '<div id="msg-box" class="card mr-3 mb-3 border-secondary" style="width: 18rem; position:fixed; bottom:0; right:0; z-index:10;">
      <div id="msg-box-header" class="card-header">click and drag</div>
      <div class="card-body" style="text-align:right;">
      <!--<h5 class="card-title">Card title</h5>-->
      <h6 class="card-subtitle mb-2 text-muted">@'. $_SESSION["username"] .'</h6>
      <div contenteditable id="msg" class="mb-3 form-control" style="white-space:pre-wrap;" placeholder="Message..."></div>
      <button onclick="sendMessage('. $chatid .')" class="mb-2 btn btn-secondary">Send</button>
      <!--create a clock here if possible-->
      <!--<h6 class="card-subtitle text-muted">'. date("j F Y g:i") .'</h6>-->
      </div>
    </div>';
}

?>