<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/home/chat/validate_chat.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/home/chat/fetch_message_cards.php" ?>
  <title>SweetChat | Chatbox</title>
<style>
.topic {
  padding: 10px;
  color: white;
  position:fixed;
  top:0;
  left:50%;
  z-index:10;
  border-bottom-left-radius:4px;
  border-bottom-right-radius:4px;
  -ms-transform: translate(-50%, 0);
  -webkit-transform: translate(-50%, 0);
  transform:translate(-50%, 0);
}
body {
  /*
  position:fixed;
  box-sizing:border-box;
  left:20px;
  right:20px;
  top:0px;
  bottom:20px;*/
  /*border:2px solid #cc00ff;
  border-radius:30px;*/
}

</style>
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	//validate chatid
	if (!validateChat($_GET["chatid"])) {
    die(
      '<div class="jumbotron jumbotron-fluid">
      <div class="container">
      <h1 class="display-4">Chat Error</h1>
      <p class="lead">You are not authorised to see this page.</p>
      </div>
      </div>'
    );
	}
  //fetchMessages($_GET["chatid"]);
  //Message input card

  $conn = connect();
  $query = $conn->prepare("select chats.color as color, chats.topic as topic from chats where chats.chatid=(?);");
  $query->bind_param("i", $_GET["chatid"]);
  $query->execute();
  $row = $query->get_result()->fetch_assoc();
  $conn->close();

  echo fetchMessageInputCard($_GET["chatid"]);
  echo '<span class="topic" style="background-color:'. $row["color"] .';">'. $row["topic"] .'</span></div><br><br><br>';
  echo '<div id="chat-container" class="d-flex flex-column bd-highlight mb-3" style="overflow-y:scroll;">';
  echo '</div>';

  echo
  '<script>
  updateChat = function() {
    var chatid = '. $_GET["chatid"] .';
    var lastupdated = "0000-00-00 00:00:00";
    return function() {
      $.ajax({
        dataType: "json",
        url: "https://sweet-chat.herokuapp.com/home/chat/fetch_messages",
        //for local testing
        //url: "fetch_messages.php",
        type: "post",
        data: {
          "chatid" : chatid,
          "lastupdated" : lastupdated,
        },
        success: function(response){
          //window.alert(response.cards);
          //window.alert(response.timestamp);
          $("#chat-container").append(
            response.cards
          );
          if (response.timestamp != "") {
            lastupdated = response.timestamp;
          }
        }
      });
    }
  }();

  setInterval(updateChat, 1000);
  </script>';
}
?>

<script src="./chatbox.js"></script>
<script src="./drag.js"></script>
</body>
</html>
