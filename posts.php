<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"];?>
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
    <title>Posts</title>
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
                    <h1><i class="fas fa-blog" style="color: aqua;"></i> Blog Posts</h1>
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
            <div class="col-lg-12">
            <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>DateTime</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <?php
                    global $connectingDB;
                    $sql = "SELECT * FROM post";
                    $stmt = $connectingDB->query($sql);
                    $Sr = 0;
                    while ($DataRows = $stmt->fetch()) {
                        $Id = $DataRows['id'];
                        $DateTime = $DataRows['dateTime'];
                        $PostTitle = $DataRows['title'];
                        $Category = $DataRows['category'];
                        $Admin = $DataRows['author'];
                        $Image = $DataRows['image'];
                        $PostText = $DataRows['post'];
                        $Sr++;

                    ?>
                        <tbody class="">
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td><?php if(strlen($PostTitle)>20){
                                    $PostTitle = substr($PostTitle,0,20).'...';
                                    echo $PostTitle;
                                }else{
                                    echo $PostTitle;
                                }  ?></td>
                                <td><?php if(strlen($Category)>8){
                                    $Category = substr($Category,0,8).'..';
                                    echo $Category; 
                                }else{
                                    echo $Category; 
                                } 
                                ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php if(strlen($Admin)>6){
                                    $Admin = substr($Admin,0,6).'...';
                                    echo $Admin;
                                }else{
                                    echo $Admin;
                                }  ?></td>
                                <td><img src="./uploads/<?php echo $Image ?>" width="70px" height="70px"> </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?php
                                        $Total = approvedComments($Id);
                                        if ($Total > 0) {
                                            echo $Total;
                                        }

                                        ?>
                                    </span>
                                    <span class="badge bg-danger">
                                        <?php
                                        $Total = unApprovedcomments($Id);
                                        if ($Total > 0) {
                                            echo $Total;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><a href="deletePost.php?id=<?php echo $Id ?>"><span class="btn btn-danger">Delete</span></a>
                                    <a href="editPost.php?id=<?php echo $Id ?>"><span class="btn btn-warning">Edit</span></a>
                                </td>
                                <td><a href="fullpost.php?id=<?php echo $Id ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                            </tr>
                        </tbody>
                    <?php } ?>
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
    <!-- <script src="./bootstrap/js/bootstrap.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.js"></script> -->

</body>

</html>