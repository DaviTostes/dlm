<?php
if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['REQUEST_METHOD'] == "POST") {
  setcookie("token", "", time() - 3600, "/");
  header("HX-Location: /login.php");
}
