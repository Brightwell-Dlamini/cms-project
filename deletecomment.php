<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php 
if(isset($_GET['id'])){
    $searchQueryParameter = $_GET['id'];
    global $connectingDB;
    $sql = "DELETE FROM comments WHERE id='$searchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    if($Execute){
        $_SESSION['successMessage']="Comment Deleted Succesfully";
        redirectTo('comments.php');
    }else{
        $_SESSION['errorMessage'] = "Something Went Wrong Try Again";
        redirectTo('comments.php');
    }
}
?>