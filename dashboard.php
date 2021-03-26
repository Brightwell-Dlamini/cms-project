<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"]; ?>
<?php confirmLogin(); ?>
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
    <title>Dashboard</title>
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
                <div class="col-md-12">
                    <h1><i class="fas fa-cog" style="color: aqua;"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="addNewPost.php" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Add New Post</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Add New Category</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="admins.php" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> Add New Admin</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block"><i class="fas fa-check"></i> Approve Comments</a>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADING ENDING -->
    <!-- MAIN AREA BEGGINING -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-2 d-none d-md-block">
                <!-- Left Side Area Start -->
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme">
                                <?php
                                totalPosts();
                                ?></i>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder">
                                <?php
                                totalCategories();
                                ?>
                            </i>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fas fa-users">
                                <?php
                                totalAdmins();
                                ?></i>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                            <i class="fas fa-comments">
                                <?php
                                echo totalComments();
                                ?></i>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Left Side Area End -->
            <!-- Right Side Area Beginning -->
            <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                    $SrNo = 0;
                    $connectingDB;
                    $sql = "SELECT*FROM post ORDER BY id desc LIMIT 0,10";
                    $stmt = $connectingDB->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $postID = $DataRows['id'];
                        $Datetime = $DataRows['dateTime'];
                        $Author = $DataRows['author'];
                        $Title = $DataRows['title'];
                        $SrNo++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($Title); ?></td>
                                <td><?php echo htmlentities($Datetime); ?></td>
                                <td><?php echo htmlentities($Author); ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?php
                                        $Total = approvedComments($postID);
                                        if ($Total > 0) {
                                            echo $Total;
                                        }

                                        ?>
                                    </span>
                                    <span class="badge bg-danger">
                                        <?php
                                        $Total = unApprovedcomments($postID);
                                        if ($Total > 0) {
                                            echo $Total;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a target="_blank" href="fullpost.php?id=<?php echo $postID; ?>"><span class="btn btn-info">Preview</span></a>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <!-- Right Side Area Ending -->
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