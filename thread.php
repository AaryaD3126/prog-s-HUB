<?php
session_start();

include 'partials/_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $comment = mysqli_real_escape_string($connection, $_POST['comment']);
        $thread_id = $_GET['thread_id'];
        $comment_by = $_SESSION["username"];
        $user_img = $_SESSION['profile'];
        $sql = "INSERT INTO comments (thread_id, comment_by, comment_content, user_img, ctime) 
        VALUES ('$thread_id', '$comment_by', '$comment', '$user_img', NOW())";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            header("Location: {$_SERVER['PHP_SELF']}?thread_id=$thread_id");
            exit();
        } else {
            echo '<script>alert("server error");</script>';
            echo '<script>window.location = "../index.php";</script>';
        }
    } else {
        echo "<script>comment cannot be emptied</script>";
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thread - Prog's HUB - A Digital Community for Coders</title>
    <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/901d7d049c.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="assets/css/thread.css">
    <style>
  <?php include "assets/css/_header.css"; ?>
  </style>
</head>

<body>
    
    <?php include "partials/_dbconnect.php" ?>
    <?php include "partials/_header.php" ?>
    <?PHP
    $id = $_GET['thread_id'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_subject'];
        $desc = $row['thread_desc'];
        $timestamp = $row['timestamp'];
        $threadUser = $row['thread_user_id'];
        $threadUserImg = $row['user_img'];
    }
    ?>
    <div class="container my-4">
        <div class="jumbotron jumbotron-custom">
            <h3 class="display-4"><b><?php echo $title; ?></b></h3>
            <p class="lead" style="font-size:20px;"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This forum is for sharing knowledge with your peers and your digital community only. Please adhere to these common rules while posting:</p>
            <ol>
                <li>Do not post copyrighted materials.</li>
                <li>Do not spam or post offensive content.</li>
                <li>Remain respectful of other members at all times.</li>
            </ol>
            <div class="comment-header">
                <?php if ($threadUserImg): ?>
                    <img src="<?php echo $threadUserImg; ?>" alt="User Image">
            
                <?php endif; ?>
                <h5>Posted By: <b><?php echo $threadUser; ?></b></h5>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                <h4>
                    <center>Post a Comment</center>
                </h4>
                <div class="mb-3">
                    <label for="comment" class="form-label">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" style="height: 120px"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>';
        } else {
            echo '<h5 style="color:green;">You are not logged in. Using an account is mandatory to post something!</h5>';
        }
        ?>
    </div>

    <div class="container comment-container">
        
        <h1 class="py-4">Browse Comments</h1>
        <?PHP
        $results_per_page = 10;
        $query = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result2 = mysqli_query($connection, $query);
        $number_of_result = mysqli_num_rows($result2);
        $number_of_page = ceil($number_of_result / $results_per_page);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $page_first_result = ($page - 1) * $result_per_page;
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id LIMIT " . $page_first_result . ',' . $results_per_page;
        $result = mysqli_query($connection, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $content = $row['comment_content'];
            $time = $row['ctime'];
            $cname = $row['comment_by'];
            $cimg = $row['user_img'];
            $cpath = ($cimg != null) ? '<img src="' . $cimg . '" style="width:50px;height:50px;border-radius:50%;">' : '';
            echo '<div class="comment-card">
                    <div class="comment-header">
                        ' . $cpath . '
                        <h5>Posted By: <b>' . $cname . '</b> at ' . $time . '</h5>
                    </div>
                    <div class="comment-content">' . $content . '</div>
                </div>';
        }
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid" style="background-color:lightgrey;padding:15px;border-radius:20px;">
                    <div class="container">
                        <h1 class="display-4">No comments Found!</h1>
                        <p class="lead">Be the first one to comment.</p>
                    </div>
                </div>';
        }
        ?>
        <div class="pagination-container">
        <?php
if ($number_of_result > 0) {
    echo '<nav class="res-pagination"  aria-label="...">
    <div class="goleft">
    <i class="fa-solid fa-caret-left fa-bounce"></i>
    </div>
    <ul class="pagination pagination-lg triangle-pagination">';

    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<li class="page-item"><a class="page-link" href= "./thread.php?thread_id=' . $id . '&page=' . $page . '">' . $page . ' </a></li>';
    }
    
    echo '</ul>
    <div class="goright">
    <i class="fa-solid fa-caret-right fa-bounce"></i>
    </div>
    </nav>';
}
?>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
        <script src="assets/js/pagination.js"></script>

</body>

</html>
