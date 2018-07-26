<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/get_friends.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
  <script src="./chstatus.js"></script>
  <title>SweetChat | Friends</title>
</head>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/homenav.php"; ?>
<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center" style="max-width: 700px;">
<h1 class="display-4">Friends</h1>
<p class="lead">Friends come at a cost. So make sure when you choose them. And when you do, love them, enjoy them, cherist them, and chat sweet with them till the very end.</p>
</div>

<?php
  $conn = connect();
  $query = $conn->prepare("select userid, username, firstname, lastname from users inner join (select userid_1 as idx from relationships where userid_2=(?) union select userid_2 as idx from relationships where userid_1=(?)) as t on users.userid=t.idx;");
  $query->bind_param("ii", $_SESSION["userid"], $_SESSION["userid"]);
  $query->execute();
  $result = $query->get_result();
  $conn->close();

  echo '<div class="row" style="width:80%; margin:auto;">';
  if ($result->num_rows == 0) {
    echo '<p class="centred">';
    echo 'You do not have any friends yet. Find new friends by searching them in the searchbar.';
    echo '</p>';
    die();
  }
  echo getFriends($result);
  echo '</div>';
?>

</body>
</html>