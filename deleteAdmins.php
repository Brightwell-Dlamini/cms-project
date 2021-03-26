<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php 
if(isset($_GET['id'])){
    $searchQueryParameter = $_GET['id'];
    global $connectingDB;
    $sql = "DELETE FROM admins WHERE id='$searchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    if($Execute){
        $_SESSION['successMessage']="Admin Removed Succesfully";
        redirectTo('deleteAdmins.php');
    }else{
        $_SESSION['errorMessage'] = "Something Went Wrong Try Again";
        redirectTo('deleteAdmins.php');
    }
}
?>