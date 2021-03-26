<?php require_once("./includes/db.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php require_once("./includes/sessions.php"); ?>
<?php $_SESSION["trackingURL"] = $_SERVER["PHP_SELF"];
?>
<?php confirmLogin(); 
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
    <title>Comments</title>
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
                <h1><i class="fas fa-comments" style="color: aqua;"></i>Manage Comments</h1>
            </div>
        </div>
    </header>
    <!-- HEADING ENDING -->

    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
            <?php
                echo errorMessage();
                echo successMessage();
                ?>
            <h2>Un-Approved Comments</h2>    
            <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                        <th>No.</th>   
                        <th>dateTime</th> 
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Approve</th>
                        <th>Action</th> 
                        <th>Details</th>
                        </tr>
                    </thead>
                
                <?php global $connectingDB;
                $sql = "SELECT * FROM comments WHERE status='OFF'ORDER BY id desc";
                $Execute = $connectingDB->query($sql);
                $SrNo = 0;
                while ($DataRows = $Execute->fetch()) {
                    $commentID = $DataRows['id'];
                    $dateTimeComment = $DataRows['dateTime'];
                    $commenterName = $DataRows['name'];
                    $commenterContent = $DataRows['comment'];
                    $commenterPostID = $DataRows['post_id'];
                    $SrNo++; 
                    if(strlen($commenterName)>10){
                        $commenterName = substr($commenterName,0,10).'..';
                    }
                    if(strlen($dateTimeComment)>10){
                        $dateTimeComment = substr($dateTimeComment,0,10).'..';
                    }if(strlen($commenterContent)>40){
                        $commenterContent = substr($commenterContent,0,40).'..';
                    }
                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo) ; ?></td>
                        <td><?php echo htmlentities($dateTimeComment);  ?></td>
                        <td><?php echo htmlentities($commenterName)  ?></td>
                        <td><?php echo htmlentities($commenterContent)  ?></td>
                        <td><a href="approvecomment.php?id=<?php echo htmlentities($commentID) ; ?>"class="btn btn-success">Approve</a></td>
                        <td><a href="deletecomment.php?id=<?php echo htmlentities($commentID) ; ?>"class="btn btn-danger">Delete</a> </td>
                        <td><a class="btn btn-primary" href="fullpost.php?id=<?php echo htmlentities( $commenterPostID); ?>">Live Preview</a></td> 
                    </tr>
                </tbody>
                <?php  } ?>
                </table>
                <h2>Approved Comments</h2>    
            <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                        <th>No.</th>   
                        <th>dateTime</th> 
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Revert</th>
                        <th>Action</th> 
                        <th>Details</th>
                        </tr>
                    </thead>
                
                <?php global $connectingDB;
                $sql = "SELECT * FROM comments WHERE status='ON'ORDER BY id desc";
                $Execute = $connectingDB->query($sql);
                $SrNo = 0;
                while ($DataRows = $Execute->fetch()) {
                    $commentID = $DataRows['id'];
                    $dateTimeComment = $DataRows['dateTime'];
                    $commenterName = $DataRows['name'];
                    $commenterContent = $DataRows['comment'];
                    $commenterPostID = $DataRows['post_id'];
                    $SrNo++; 
                    if(strlen($commenterName)>10){
                        $commenterName = substr($commenterName,0,10).'..';
                    }
                    if(strlen($dateTimeComment)>10){
                        $dateTimeComment = substr($dateTimeComment,0,10).'..';
                    }if(strlen($commenterContent)>40){
                        $commenterContent = substr($commenterContent,0,40).'..';
                    }
                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo) ; ?></td>
                        <td><?php echo htmlentities($dateTimeComment);  ?></td>
                        <td><?php echo htmlentities($commenterName)  ?></td>
                        <td><?php echo htmlentities($commenterContent)  ?></td>
                        <td><a href="disapproveComment.php?id=<?php echo htmlentities($commentID) ; ?>"class="btn btn-warning">Dis-approve</a></td>
                        <td><a href="deletecomment.php?id=<?php echo htmlentities($commentID) ; ?>"class="btn btn-danger">Delete</a> </td>
                        <td><a class="btn btn-primary" href="fullpost.php?id=<?php echo htmlentities( $commenterPostID); ?>">Live Preview</a></td> 
                    </tr>
                </tbody>
                <?php  } ?>
                </table>
            </div>
        </div>
    </section>

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