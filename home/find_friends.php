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
<h1 class="display-4">Find Friends...</h1>
<p class="lead">Find your 'Joey' and sweet chat.</p>
</div>

<?php
  $conn = connect();
  $query = $conn->prepare("select userid, username, firstname, lastname from users where username=(?);");
  $query->bind_param("s", $_GET["searchtext"]);
  $query->execute();
  $result = $query->get_result();
  $conn->close();

  echo '<div class="row" style="width:80%; margin:auto;">';
  if ($result->num_rows == 0) {
    echo '<p class="centred">';
    echo $_GET["searchtext"] . ' was not found. Please enter a valid username.';
    echo '</p>';
    die();
  }
  echo getFriends($result);
  echo '</div>';
?>
</body>
</html>