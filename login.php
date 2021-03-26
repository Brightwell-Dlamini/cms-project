<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php 
if(isset($_SESSION["userID"])){
    redirectTo("dashboard.php");
}
?>
<?php  
if(isset($_POST["Submit"])){
    $userName = $_POST["username"];
    $Password = $_POST["Password"];

    if(empty($userName)|| empty($Password)){
        $_SESSION["errorMessage"] = "All Fields Must Be Filled out";
        redirectTo("login.php");
    }else{
        $foundAccount = loginAttempt($userName, $Password);
        if($foundAccount){
            $_SESSION["userID"] = $foundAccount['id'];
            $_SESSION["username"] = $foundAccount['userName'];
            $_SESSION["adminName"] = $foundAccount['AdmName'];
            $_SESSION['successMessage'] = "Welcome {$userName}";
            if(isset( $_SESSION["trackingURL"])){
                redirectTo($_SESSION['trackingURL']);
            }else{
                redirectTo("dashboard.php");
            }
        }else{
            $_SESSION['errorMessage'] = "Incorrect Username Or Password";
            redirectTo("login.php");
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./icons/js/fontawesome.js"></script>
    <link rel="stylesheet" href="./icons/all.css">
    <title>Login</title>
</head>

<body>
    <!-- NAVBAR BEGGINING -->
    <div style="height: 5px; background-color: aqua;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">Gerv.Com</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div style="height: 5px; background-color: aqua;"></div>
    <!-- NAVBAR ENDING -->
    <!-- HEADING BEGINNING -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12"></div>

            </div>
        </div>
    </header>
    <!-- HEADING ENDING -->

    <!-- MAIN AREAR BEGINNING -->
    <section class="container py-3 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:100vh;">
            <?php echo errorMessage(); echo successMessage(); ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome Back!!</h4></div>
                        <div class="card-body bg-dark">

                        
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Username:</span></label>
                                <div class="input-group mb-3">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="Type Your Username Here">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Password:</span></label>
                                <div class="input-group mb-3">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="Password" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="d-grid gap-2"> <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login"></div>
                            
                        </form>
                    </div>
                </div>

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
    <!-- <script src="./bootstrap/js/bootstrap.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.js"></script> -->

</body>

</html>