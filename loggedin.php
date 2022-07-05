<?php
session_start();

if (array_key_exists('id', $_COOKIE) && $_COOKIE['id']) {
    $_SESSION['id'] = $_COOKIE['id'];
}

if (array_key_exists('id', $_SESSION) && $_SESSION['id']) {

    include("connection.php");
    $query = "SELECT diary FROM `users` WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";
    $row = mysqli_fetch_array(mysqli_query($link, $query));
    $diary = $row['diary'];
} else {
    header("Location: index.php");
}

include("header.php");
?>
<nav class="navbar navbar-expand-lg bg-light navbar-fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Secret Diary</a>
      <div class="pull-xs-right">
        <a href="index.php?Logout=1"><button class="btn btn-outline-success" type="submit">Logout</button></a>
      </div>
    </div>
  </div>
</nav>
<div class="container-fluid" id="loginPage">

    <textarea name="diary" id="diary" class="form-control" cols="30" rows="10"><?php echo $diary; ?></textarea>

</div>

<?php
include("footer.php");

?>