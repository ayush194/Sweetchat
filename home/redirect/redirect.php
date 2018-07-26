<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php
if (isset($_SESSION["redirect"])) {
	header("Location: " . $_SESSION["redirect"]);
}
?>