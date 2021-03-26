<?php require_once("./includes/db.php") ?>
<?php
function redirectTo($newLocation)
{
    header("Location:" . $newLocation);
    exit;
}
function checkUsernameExistence($userName)
{
    global $connectingDB;
    $sql = "SELECT username FROM admins WHERE username = :userName";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName', $userName);
    $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
function loginAttempt($userName, $Password)
{
    //query to check username and password in the database
    global $connectingDB;
    $sql = "SELECT * FROM admins WHERE userName=:username AND password=:Password LIMIT 1";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':username', $userName);
    $stmt->bindValue(':Password', $Password);
    $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1) {
        return $foundAccount = $stmt->fetch();
    } else {
        return null;
    }
}
function confirmLogin()
{
    if (isset($_SESSION['userID'])) {
        return true;
    } else {
        $_SESSION['errorMessage'] = "Login Required!!";
        redirectTo("login.php");
    }
}

function totalComments()
{
    global $connectingDB;
    $sql = 'SELECT COUNT(*) FROM comments';
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo  $TotalComments;
}
function totalAdmins()
{
    global $connectingDB;
    $sql = 'SELECT COUNT(*) FROM admins';
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}
function totalCategories()
{
    global $connectingDB;
    $sql = 'SELECT COUNT(*) FROM category';
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;
}
function totalPosts()
{
    global $connectingDB;
    $sql = 'SELECT COUNT(*) FROM post';
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}
function approvedComments($postID)
{
    global $connectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments 
    WHERE post_id='$postID' AND status='ON'";
    $stmtApprove = $connectingDB->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
function unApprovedcomments($postID){
    global $connectingDB;
    $sqlunapproved = "SELECT COUNT(*) FROM comments 
    WHERE post_id='$postID' AND status='OFF'";
    $stmtunapproved = $connectingDB->query($sqlunapproved);
    $RowsTotal = $stmtunapproved->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

?>