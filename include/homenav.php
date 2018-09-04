<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand" href="#">
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/logo.html"; ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/home/home">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home/friends">Friends</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home/chats">Chats</a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <form action="find_friends.php" method="get" class="input-group">
          <input type="text" class="form-control" placeholder="Find Friends..." aria-label="Recipient's username" aria-describedby="basic-addon2" name="searchtext">
        <div class="input-group-append">
        <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
        </div>
        </form>
      </li>
      <!--
      <li class="search-container">
        <form action="/action_page.php">
        <input type="text" placeholder="Find Friends.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </li>-->
      <li><a class="nav-link" href="/login/logout">Logout</a></li>
    </ul>
  </div>
</nav>