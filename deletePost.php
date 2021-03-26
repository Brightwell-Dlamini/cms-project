<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"];?>
<?php confirmLogin(); ?>
<!-- FORM VALIDATION BEGGINING -->
<?php
$searchQueryParameter = $_GET["id"];
global $connectingDB;
$sql = "SELECT * FROM posts WHERE id='$searchQueryParameter'";
$stmt = $connectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $titleToBeDeleted = $DataRows['title'];
    $categoryToBeDeleted = $DataRows['category'];
    $imageToBeDeleted = $DataRows['image'];
    $postToBeDeleted = $DataRows['post'];
}

if (isset($_POST["Submit"])) {

    //Query to delete Post in database if everything is fine
    global $connectingDB;
    $sql = "DELETE FROM posts WHERE id='$searchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    var_dump($Execute);

    if ($Execute) {
        $Target_Path_To_Delete_Image = "uploads/$imageToBeDeleted";
        unlink($Target_Path_To_Delete_Image);
        $_SESSION["successMessage"] = "Post Deleted Succesfully";
        redirectTo("posts.php");
    } else {
        $_SESSION["errorMessage"] = "Something Went Wrong Try Again";
        redirectTo("posts.php");
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

    <title>Delete Post</title>
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
                <h1><i class="fas fa-edit" style="color: aqua;"></i> Delete Post</h1>
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

                <form class="" action="deletePost.php?id=<?php echo $searchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Post Title:</span></label>
                                <input disabled class="form-control" type="text" name="postTitle" id="title" placeholder="Type Title Here" value="<?php echo $titleToBeDeleted; ?>">
                            </div>
                            <div class="form-group">
                                <hr>
                                <span class="fieldInfo">Existing Category: </span><?php echo $categoryToBeDeleted; ?>
                                <hr>
                            </div>
                            <div class="form-group mb-1">
                                <hr>
                                <span class="fieldInfo">Existing Image: </span>
                                <img src="./uploads/<?php echo $imageToBeDeleted ?>" width="170px" height="70px">
                                <?php echo $imageToBeDeleted; ?>
                                <hr>
                                <label for="imageSelect"><span class="fieldInfo">Select Image</span></label>
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="fieldInfo"> Post:</span></label>
                                <textarea disabled class=" form-control" name="postDescription" id="post" cols="30" rows="10" value=""><?php echo $postToBeDeleted; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 d-grid gap-2 mt-3">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Delete</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
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