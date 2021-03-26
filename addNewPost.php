<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"];?>
<?php confirmLogin(); ?>

<!-- FORM VALIDATION BEGGINING -->
<?php
if (isset($_POST["Submit"])) {
    $postTitle = $_POST["postTitle"];
    $category = $_POST["category"];
    $imageName = $_FILES["image"]["name"];
    $target = "uploads/".basename($_FILES["image"]["name"]);
    $postText = $_POST["postDescription"];
    $Admin =  $_SESSION["username"];
    echo date_default_timezone_get();
    $currentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);


    if (empty($postTitle)) {
        $_SESSION["errorMessage"] = "Title Cannot Be Empty";
        redirectTo("addNewPost.php");
    } elseif (strlen($postTitle) < 2) {
        $_SESSION["errorMessage"] = "Post Title Should Be Greater than two Characters";
        redirectTo("addNewPost.php");
    } elseif (strlen($postText) > 999) {
        $_SESSION["errorMessage"] = "Post Description should not be greater than 999 characters";
        redirectTo("addNewPost.php");
    } else {

        //Query to insert Post in database if everything is fine
        global $connectingDB;
        $sql = "INSERT INTO post(dateTime,title,category,author,image,post)";
        $sql .= "VALUES(:datetime, :posttitle, :categoryName, :adminName, :imagename, :postdescription)";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':datetime', $DateTime);
        $stmt->bindValue(':posttitle',$postTitle);
        $stmt->bindValue(':categoryName', $category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imagename',$imageName);
        $stmt->bindValue(':postdescription',$postText);
        $Execute=$stmt->execute();
        move_uploaded_file($_FILES["image"]["tmp_name"],$target);

        if ($Execute) {
            $_SESSION["successMessage"] = "Post with ID  " . $connectingDB->lastInsertId() . " Added Succesfully";
            redirectTo("addNewPost.php");
        } else {
            $_SESSION["errorMessage"] = "Something Went Wrong Try Again";
            redirectTo("addNewPost.php");
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
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./icons/js/fontawesome.js"></script>

    <title>Add New Post</title>
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
                <h1><i class="fas fa-edit" style="color: aqua;"></i> Add New Post</h1>
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

                <form class="" action="addNewPost.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Post Title:</span></label>
                                <input class="form-control" type="text" name="postTitle" id="title" placeholder="Type Title Here">
                            </div>
                            <div class="form-group">
                                <label for="categoryTitle"><span class="fieldInfo">Choose Category</span></label>
                                <select class="form-control" name="category" id="categoryTitle">
                                    <?php
                                    //fetching all the categories for category table
                                    global $connectingDB;
                                    $sql = "SELECT*FROM category";
                                    $stmt = $connectingDB->query($sql);
                                    while ($DataRows=$stmt->fetch()) {
                                        $Id = $DataRows["id"];
                                        $categoryName = $DataRows["title"];
                                    ?>
                                    <option><?php echo $categoryName; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imageSelect"><span class="fieldInfo">Select Image</span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="image" id="imageSelect">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="fieldInfo"> Post:</span></label>
                                <textarea class="form-control" name="postDescription" id="post" cols="30" rows="10"></textarea>
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
   


</body>

</html>