<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>

<?php
$_SESSION["userID"] = null;
$_SESSION["username"] = null;
$_SESSION["adminName"] =null;
session_destroy();
redirectTo("login.php");
?>