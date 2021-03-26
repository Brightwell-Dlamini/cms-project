<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php 
if(isset($_GET['id'])){
    $searchQueryParameter = $_GET['id'];
    global $connectingDB;
    $Admin =  $_SESSION["username"];
    $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$searchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    if($Execute){
        $_SESSION['successMessage']="Comment Dis-Approved Succesfully";
        redirectTo('comments.php');
    }else{
        $_SESSION['errorMessage'] = "Something Went Wrong Try Again";
    }
}
?>