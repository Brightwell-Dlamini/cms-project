<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"];?>
<?php confirmLogin(); ?>

<!-- FORM VALIDATION BEGGINING -->
<?php
if (isset($_POST["Submit"])) {
//id	dateTime	userName	password	AdmName	addedby	
    $userName = $_POST["username"];
    $Name = $_POST["name"];
    $Password = $_POST["Password"];
    $confirmPassword  = $_POST["confirmPassword"];
    $Admin =  $_SESSION["username"];
    echo date_default_timezone_get();
    $currentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);


    if (empty($userName)||empty($Password)||empty($confirmPassword)) {
        $_SESSION["errorMessage"] = "All Fields Must Be Filled out";
        redirectTo("admins.php");
    } elseif (strlen($Password) < 5) {
        $_SESSION["errorMessage"] = "Password Should Be Greater than 5 Characters";
        redirectTo("admins.php");
    } elseif ($Password !== $confirmPassword) {
        $_SESSION["errorMessage"] = "The Password does not match";
        redirectTo("admins.php");
    } elseif(checkUsernameExistence($userName)){
        $_SESSION["errorMessage"] = "Username Already Taken, Try a New Username";
        redirectTo("admins.php");
    }else{

        //Query to insert admin in database if everything is fine
        
//id	dateTime	userName	password	AdmName	addedby	
        $sql = "INSERT INTO admins(dateTime,userName,password,AdmName,addedby)";
        $sql.="VALUES(:datetime,:userName,:password, :adminName,:addedby)";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':datetime',$DateTime);
        $stmt->bindValue(':userName',$userName);
        $stmt->bindValue(':password',$Password);
        $stmt->bindValue(':adminName',$Name);
        $stmt->bindValue(':addedby',$Admin);
        $Execute=$stmt->execute();

        if($Execute){
            $_SESSION["successMessage"] = "New Admin With The User Name {$userName} Added Succesfully";
            redirectTo("admins.php");
        }else{
            $_SESSION["errorMessage"] = "Something Went Wrong Try Again";
            redirectTo("admins.php");
        }
    }
}
//Ending of the submit button
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./icons/js/fontawesome.js"></script>
    
    <title>Admin Page</title>
</head>

<body>
    <!-- NAVBAR BEGGINING -->
    <div style="height: 5px; background-color: aqua;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="home.php" class="navbar-brand">Gerv.Com</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="profile.php" class="nav-link"><i class="fa fa-user text-warning"></i>
                            My Profile</a></li>
                    <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="posts.php" class="nav-link">Posts</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="admins.php" class="nav-link">Manage Admins</a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link">Comments</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Live Blog</a></li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-user-times text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 5px; background-color: aqua;"></div>
    <!-- NAVBAR ENDING -->
    <!-- HEADING BEGINNING -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <h1><i class="fas fa-user" style="color: aqua;"></i> Manage Admins</h1>
            </div>
        </div>
    </header>
    <!-- HEADING ENDING -->
    <!-- MAIN AREA BEGINNING -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:100vh;">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>

                <form class="" action="admins.php" method="POST">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Username:</span></label>
                                <input class="form-control" type="text" name="username" id="username"placeholder="Type Username Here">
                            </div>
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Name:</span></label>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Type Name Here">
                                <small class="text-warning text-muted">Optional*</small>
                            </div>
                            <div class="form-group">
                                <label for="Password"><span class="fieldInfo">Password:</span></label>
                                <input class="form-control" type="password" name="Password" id="password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword"><span class="fieldInfo">Confirm Password:</span></label>
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Add Admin</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Admin Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php global $connectingDB;
                    $sql = "SELECT * FROM admins ORDER BY id desc";
                    $Execute = $connectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $AdminID = $DataRows['id'];
                        $AdminUserName = $DataRows['userName'];
                        $AdminDate = $DataRows['dateTime'];
                        $creatorName = $DataRows['addedby'];
                        $SrNo++;
                        if (strlen($AdminDate) > 10) {
                            $AdminDate = substr($AdminDate, 0, 10) . '..';
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($AdminDate);  ?></td>
                                <td><?php echo htmlentities($AdminUserName)  ?></td>
                                <td><?php echo htmlentities($creatorName)  ?></td>
                                <td><a href="deleteAdmins.php?id=<?php echo htmlentities($AdminID); ?>" class="btn btn-danger">Delete</a></td>
                            </tr>
                        </tbody>
                    <?php  } ?>
                </table>
            </div>


        </div>
    </section>

    <!-- MAIN AREA ENDING -->

    <!-- FOOTER BEGGINING -->
    <div style="height: 5px; background-color: aqua;"></div>
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <p class="lead text-center">Theme By Siyabonga Dlamini <script>
                        document.write(new Date().getFullYear());
                    </script> &copy; All Rights Reserved</p>
            </div>
        </div>
    </footer>
    <div style="height: 5px; background-color: aqua;"></div>
    <!-- FOOTER ENDING -->

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>


</body>

</html>