<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
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
    <title>Blog Page</title>
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
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="blog.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Feautures</a></li>

                </ul>
                <ul class="navbar-nav ml-auto">
                    <form action="blog.php">
                        <div class="form-group">
                        <div class="input-group">
                        <input type="text" class="form-control rounded mr-2" placeholder="Search" aria-label="Search" aria-describedby="search-addon" name="Search" />
                        <button class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                            
                        </div>
                    </form>
                </ul>

            </div>
        </div>
    </nav>
    <div style="height: 5px; background-color: aqua;"></div>
    <!-- NAVBAR ENDING -->
    <!-- HEADER BEGINNING -->
    <div class="container">
        <!-- Main Area Beginning -->
        <div class="row mt-4">
            <div class="col-sm-8">
                <h1>The complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete Blog by using PHP By Siyabonga Dlamini Brightwell</h1>
                <?php echo errorMessage();
                echo successMessage(); ?>
                <?php
                global $connectingDB;
                //SQL query when search button is active
                if (isset($_GET['SearchButton'])) {
                    $Search = $_GET['Search'];
                    $sql = "SELECT * FROM post WHERE 
                    dateTime LIKE :search 
                    OR title LIKE :search
                    OR category LIKE :search
                    OR post LIKE :search";
                    $stmt = $connectingDB->prepare($sql);
                    $stmt->bindValue(':search', '%' . $Search . '%');
                    $stmt->execute();
                } elseif (isset($_GET['page'])) {
                    $Page = $_GET['page'];
                    if ($Page == 0) {
                        $showPostFrom = 0;
                    } else {
                        $showPostFrom = ($Page * 4) - 4;
                    }

                    $sql = "SELECT * FROM post  ORDER BY id desc LIMIT $showPostFrom,4";
                    $stmt = $connectingDB->query($sql);
                } elseif (isset($_GET['category'])) {
                    $Category = $_GET['category'];
                    $sql = "SELECT * FROM post WHERE category = '$Category' ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                }

                //the default SQL query
                else {
                    $sql = "SELECT * FROM post ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                }
                while ($DataRows = $stmt->fetch()) {
                    $PostID = $DataRows['id'];
                    $DateTime = $DataRows['dateTime'];
                    $PostTitle = $DataRows['title'];
                    $Category = $DataRows['category'];
                    $Admin = $DataRows['author'];
                    $Image = $DataRows['image'];
                    $PostDescription = $DataRows['post'];
                ?>
                    <div class="card mb-2">
                        <img src="./uploads/<?php echo htmlentities($Image)  ?>" class="img-fluid" alt="">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlentities($PostTitle) ?></h3>
                            <small class="text-muted">Category <?php echo htmlentities($Category); ?> & Written By <?php echo htmlentities($Admin); ?> on <?php echo htmlentities($DateTime)  ?></small>
                            <span style="float: right;" class="badge bg-primary">Comments <?php echo approvedComments($PostID); ?> </span>
                            <hr>
                            <p class="card-text">
                                <?php
                                if (strlen($PostDescription) > 150) {
                                    $PostDescription = substr($PostDescription, 0, 150);
                                    echo $PostDescription . '...';
                                } else {
                                    echo $PostDescription;
                                }
                                ?></p>
                            <a href="fullPost.php?id= <?php echo $PostID ?>" style="float: right;"><span class="btn btn-info"> Read More>></span></a>
                        </div>

                    </div>
                <?php } ?>
                <!-- Pagination Starts -->
                <nav>
                    <ul class="pagination pagination-md">
                        <!-- Creating a Backward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) {
                        ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                                </li>
                        <?php }
                        } ?>
                        <?php
                        global $connectingDB;
                        $sql = "SELECT COUNT(*) FROM post";
                        $stmt = $connectingDB->query($sql);
                        $rowPagination = $stmt->fetch();
                        $totalPosts = array_shift($rowPagination);
                        //echo $totalPosts;
                        $postPagination = $totalPosts / 4;
                        $postPagination = ceil($postPagination);
                        //echo $postPagination;
                        for ($i = 1; $i <= $postPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                        <?php }
                        } ?>
                        <!-- Creating a Foward Button -->
                        <?php
                        if (isset($Page) && !empty($Page)) {
                            if ($Page + 1 <= $postPagination) {
                        ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                </nav>
            </div>
            <!-- Main Area Ends -->
            <!-- Side Area Starts -->
            <div class="col-sm-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <img src="./images/1060-536x354-blur_2.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            advertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvertadvert
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="card-title">Sign Up Today</h2>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-3 " name="button">Join Forum</button>
                        <button type="button" class="btn btn-danger btn-block text-center text-white mb-3" name="button">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter your email">
                            <div class="input-group-text ml-1">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white ">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-4">
                    <div class="card-header bg-primary text-light">
                        <h2 class="card-title">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $connectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $categoryID = $DataRows['id'];
                            $categoryName = $DataRows['title'];
                        ?>
                            <a href="blog.php?category=<?php echo $categoryName; ?>"><span class="heading"><?php echo $categoryName; ?></span></a><br>
                        <?php } ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-info text-light">
                        <h2 class="card-title">
                            Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                        $stmt = $connectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $Id = $DataRows['id'];
                            $Title = $DataRows['title'];
                            $DateTime = $DataRows['dateTime'];
                            $Image = $DataRows['image'];
                        ?>
                            <div class="container mt-3">
                                <div class="flex-shrink-0 mr-3 mt-3 rounded-circle">
                                    <img src="uploads/<?php echo htmlentities($Image); ?>" class="flex-shrink-0 mr-3 mt-3 rounded-circle" width="90" height="94" alt="">
                                </div>

                                <div>
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
            <!-- Side Area Ends -->
        </div>
    </div>
    <!-- HEADER ENDING -->

    <!-- FOOTER BEGGINING -->
    <div style="height: 5px; background-color: aqua;"></div>
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <p class="card-title text-center">Theme By Siyabonga Dlamini <script>
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