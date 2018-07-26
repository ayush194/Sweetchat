<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/sessions.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/metadata.html"; ?>
  <title>SweetChat | Home</title>
</head>

<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/homenav.php"; ?>
  <div class="centred"><?php echo "Welcome " . $_SESSION["username"]; ?></div>
</body>

</html>