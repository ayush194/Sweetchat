<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>
<?php include "chat/chat_cards.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
  <script src="./chstatus.js"></script>
  <script src="jscolor.js"></script>
  <script src="./add_chat.js"></script>
  <!--<script src="../signup/validate.js"></script>-->
  <title>SweetChat | Chats</title>
</head>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/homenav.php"; ?>
<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center" style="max-width: 700px;">
<h1 class="display-4">Chats</h1>
<p class="lead">Start blabbering all your inner thoughts and deep feelings about the other one...</p>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["member0"])) {
    $conn = connect();
    $query = $conn->prepare("insert into chats (userid, topic, color) values (?, ?, ?);");
    $_POST["chatcolor"] = "#" . $_POST["chatcolor"];
    $query->bind_param("iss", $_SESSION["userid"], $_POST["chattopic"], $_POST["chatcolor"]);
    $query->execute();
    $chatid = $conn->insert_id;
    //foreach ($_POST["members"] as $member) {
    $idx = 0;
    while (isset($_POST["member" . $idx])) {
      $member = $_POST["member" . $idx];
      $query = $conn->prepare("select users.userid as userid from users where username=(?);");
      $query->bind_param("s", $member);
      $query->execute();
      $userid = $query->get_result()->fetch_assoc()["userid"];
      $query = $conn->prepare("insert into chatusers (chatid, userid) values (?, ?);");
      $query->bind_param("ii", $chatid, $userid);
      $query->execute();
      $idx += 1;
    }
    $_SESSION["redirect"] = "/home/chats";
    header("Location: /home/redirect/redirect");
    //}
  }
}
?>

<?php
	$conn = connect();
	$query = $conn->prepare("select u.chatid, u.userid, users.username, users.firstname, users.lastname, u.topic, u.color from (select t.chatid as chatid, chats.userid as userid, chats.topic as topic, chats.color as color from (select chatusers.chatid as chatid from chatusers where chatusers.userid=(?)) as t inner join chats on t.chatid=chats.chatid) as u inner join users on u.userid=users.userid;");
	$query->bind_param("i", $_SESSION["userid"]);
	$query->execute();
	$result = $query->get_result();
	$conn->close();

  echo '<div class="row" style="width:80%; margin:auto;">';
  if ($result->num_rows == 0) {
    echo '<p class="centred">';
    echo 'You haven&apos;t started any chats yet. Click on the button below to create a new chat.';
    echo '</p>';   
  } else {
    echo getChatCards($result);
  }
  echo '</div>';
?>

<div id="create-chat-popup" class="card mx-auto mb-4" style="display:none; position:fixed; bottom:5%; right:10%; border-color:#ab2567; width: 18rem; ">
  <div class="card-body d-flex flex-column">
    <form id="create-chat-form" method="post" action="">
      <input class="card-title form-control" name="chattopic" placeholder="Topic" required="">
      <div class="card-text">Members :</div>
      <div id="create-chat-members" class="d-flex mt-auto flex-column">

        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
          </div>
          <input class="form-control" name="member0" value="<?php echo $_SESSION["username"] ?>" readonly required>
          <div class="input-group-append">
            <span onclick="addMember(this)" class="btn btn-primary" style="width:35px;" id="basic-addon2">+</span>
          </div>
        </div>

      </div>
      <div class="card-text">Color : </div><input onchange="colorChange(this)" class="jscolor form-control mb-5" name="chatcolor" value="ab2567">
      <input id="create-chat-form-submit" class="btn btn-primary" type="submit" value="CreateChat">
    </form>
  </div>
</div>

<button onclick="createChatPopup(this)" type="button" class="btn btn-info" style="position:fixed; width:40px; height:40px; bottom:5%; right:5%; border-radius:50%;">+</button>
</body>
</html>