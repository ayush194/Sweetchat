<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/connect/connect.php"; ?>

<?php
function changeStatus($userid_1, $userid_2, $istatusid, $fstatusid) {
	$conn = connect();
  if ($istatusid == -1) {
    $query = $conn->prepare("insert into relationships values (?, ?, ?);");
    $query->bind_param("iii", $userid_1, $userid_2, $fstatusid);
  } else if ($fstatusid == -1) {
    $query = $conn->prepare("delete from relationships where userid_1=(?) and userid_2=(?);");
    $query->bind_param("ii", $userid_1, $userid_2);
  } else {
    $query = $conn->prepare("update relationships set statusid=(?) where userid_1=(?) and userid_2=(?);");
    $query->bind_param("iii", $fstatusid, $userid_1, $userid_2);
  }
	$query->execute();
  $conn->close();
  echo "status_updated";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo changeStatus($_POST["userid_1"], $_POST["userid_2"], $_POST["istatusid"], $_POST["fstatusid"]);
}
?>
