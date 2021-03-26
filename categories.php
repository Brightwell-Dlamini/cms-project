<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"]; ?>
<?php confirmLogin(); ?>


<!-- FORM VALIDATION BEGGINING -->
<?php
if (isset($_POST["Submit"])) {
    $category = $_POST["categoryTitle"];
    $Admin =  $_SESSION["username"];
    //$_SESSION['adminName'];
    date_default_timezone_get();
    $currentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);


    if (empty($category)) {
        $_SESSION["errorMessage"] = "All Fields Must Be Filled out";
        redirectTo("categories.php");
    } elseif (strlen($category) < 2) {
        $_SESSION["errorMessage"] = "Title Should Be Greater than two Characters";
        redirectTo("categories.php");
    } elseif (strlen($category) > 49) {
        $_SESSION["errorMessage"] = "Title should not be greater than 49 characters";
        redirectTo("categories.php");
    } else {

        //Query to insert category in database if everything is fine
        $sql = "INSERT INTO category(title,author,dateTime)";
        $sql .= "VALUES(:categoryName, :adminName, :datetime)";
        $stmt = $connectingDB->prepare($sql);
        //$stmt = mysqli_prepare()
        $stmt->bindValue(':categoryName', $category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':datetime', $DateTime);
        $Execute = $stmt->execute();


        if ($Execute) {
            $_SESSION["successMessage"] = "Category with ID : " . $connectingDB->lastInsertId() . " Added Succesfully";
            redirectTo("categories.php");
        } else {
            $_SESSION["errorMessage"] = "Something Went Wrong Try Again";
            redirectTo("categories.php");
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

    <title>Categories</title>
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
                <h1><i class="fas fa-edit" style="color: aqua;"></i> Manage Categories</h1>
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

                <form class="" action="categories.php" method="POST">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Category Title:</span></label>
                                <input class="form-control" type="text" name="categoryTitle" id="title" placeholder="Type Title Here">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Publish</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <h2>Existing Categories</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>dateTime</th>
                            <th>Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php global $connectingDB;
                    $sql = "SELECT * FROM category ORDER BY id desc";
                    $Execute = $connectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $categoryID = $DataRows['id'];
                        $categoryDate = $DataRows['dateTime'];
                        $categoryName = $DataRows['title'];
                        $creatorName = $DataRows['author'];
                        $SrNo++;

                        if (strlen($categoryDate) > 10) {
                            $categoryDate = substr($categoryDate, 0, 10) . '..';
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($categoryDate);  ?></td>
                                <td><?php echo htmlentities($categoryName)  ?></td>
                                <td><?php echo htmlentities($creatorName)  ?></td>
                                <td><a href="deletecategory.php?id=<?php echo htmlentities($categoryID); ?>" class="btn btn-danger">Delete</a></td>
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