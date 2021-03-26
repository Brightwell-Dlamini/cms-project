<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if (isset($_POST["Submit"])) {
    $Name    = $_POST["CommenterName"];
    $Email   = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["errorMessage"] = "All fields must be filled out";
        RedirectTo("fullpost.php?id={$SearchQueryParameter}");
    } elseif (strlen($Comment) > 500) {
        $_SESSION["errorMessage"] = "Comment length should be less than 500 characters";
        RedirectTo("fullpost.php?id={$SearchQueryParameter}");
    } else {
        // Query to insert comment in DB When everything is fine
        global $ConnectingDB;
        $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
        $Execute = $stmt->execute();
        //var_dump($Execute);
        if ($Execute) {
            $_SESSION["successMessage"] = "Comment Submitted Successfully";
            RedirectTo("fullpost.php?id={$SearchQueryParameter}");
        } else {
            $_SESSION["errorMessage"] = "Something went wrong. Try Again !";
            RedirectTo("fullpost.php?id={$SearchQueryParameter}");
        }
    }
} //Ending of Submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./icons/js/fontawesome.js"></script>
    <style media="screen">
        .heading {
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005E90;
        }

        .heading:hover {
            color: #0090DB;
        }
    </style>
    <title>Full Post Page</title>

</head>

<body>
    <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"> Gerv.Com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="form-group">
                            <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
                            <button class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <div class="container">
        <div class="row mt-4">
            <!-- Main Area Start-->
            <div class="col-sm-8 ">
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by using PHP by Jazeb Akram</h1>
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <?php
                global $ConnectingDB;
                // SQL query when Searh button is active
                if (isset($_GET["SearchButton"])) {
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM post
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':search', '%' . $Search . '%');
                    $stmt->execute();
                }
                // The default SQL query
                else {
                    $PostIdFromURL = $_GET["id"];
                    if (!isset($PostIdFromURL)) {
                        $_SESSION["errorMessage"] = "Bad Request !";
                        redirectTo("blog.php?page=1");
                    }
                    $sql  = "SELECT * FROM post  WHERE id= '$PostIdFromURL'";
                    $stmt = $connectingDB->query($sql);
                    $Result = $stmt->rowcount();
                    if ($Result != 1) {
                        $_SESSION["errorMessage"] = "Bad Request !";
                        redirectTo("blog.php?page=1");
                    }
                }
                while ($DataRows = $stmt->fetch()) {
                    $PostId          = $DataRows["id"];
                    $DateTime        = $DataRows["dateTime"];
                    $PostTitle       = $DataRows["title"];
                    $Category        = $DataRows["category"];
                    $Admin           = $DataRows["author"];
                    $Image           = $DataRows["image"];
                    $PostDescription = $DataRows["post"];
                ?>
                    <div class="card">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                            <small class="text-muted">Category: <span class="text-dark"> <a href="blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a href="profile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                            <hr>
                            <p class="card-text">
                                <?php echo nl2br($PostDescription); ?></p>
                        </div>
                    </div>
                    <br>
                <?php   } ?>
                <!-- Comment Part Start -->
                <!-- Fetching existing comment START  -->
                <span class="fieldInfo">Comments</span>
                <br><br>
                <?php
                global $ConnectingDB;
                $sql  = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                $stmt = $connectingDB->query($sql);
                while ($DataRows = $stmt->fetch()) {
                    $CommentDate   = $DataRows['dateTime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];
                ?>
                    <div>
                        <div class="media CommentBlock d-flex p-2">
                            <img class="d-block img-fluid align-self-start" height="60px" width="60px" src="images/866-536x354.jpg" alt="">
                            <div class="media-body ml-2">
                                <h6 class="lead"><?php echo $CommenterName; ?></h6>
                                <p class="small"><?php echo $CommentDate; ?></p>
                                <p><?php echo $CommentContent; ?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>

                <!--  Fetching existing comment END -->

                <div>
                    <form class="" action="fullpost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="fieldInfo">Share your thoughts about this post</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input class="form-control" type="text" name="CommenterEmail" placeholder="Email" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Comment Part End -->
            </div>
            <!-- Main Area End-->

            <!-- Side Area Start -->
            <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="/uploads/0_Marcus-Rashford-file-photo.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up !</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
                        <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $connectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                            <a href="Blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading"> <?php echo $CategoryName; ?></span> </a><br>
                        <?php } ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h2 class="lead"> Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                        $stmt = $connectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $Id     = $DataRows['id'];
                            $Title  = $DataRows['title'];
                            $DateTime = $DataRows['dateTime'];
                            $Image = $DataRows['image'];
                        ?>
                            <div class="media">
                                <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                                <div class="media-body ml-2">
                                    <a style="text-decoration:none;" href="fullpost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                                        <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
                                    </a>
                                    <p class="small"><?php echo htmlentities($DateTime); ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <!-- Side Area End -->
        </div>

    </div>

    <!-- HEADER END -->
    <!-- FOOTER -->
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
    <!-- FOOTER END-->

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>

    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>
<?php //require_once("footer.php");
?>