<?php
session_start();
if (isset($_GET["catid"])) {
    include 'partials/_dbconnect.php';
    $catid = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id='$catid'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $name = $_SESSION["username"];
    $profile = $_SESSION['profile'];
    if ($_SESSION['profile']) {
        $profile_img = '<img class="mx-1" src="' . $profile . '" alt="..." style="width:50px;height:50px;border-radius:50%;">';
    }
} else {
    $profile_img = " ";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>threads - Prog's HUB - a digital community for coders</title>
    <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/901d7d049c.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/thread_list.css">
    <style>
       

        <?php include "assets/css/_header.css"; ?>
    </style>
</head>

<body>
    <?php include "partials/_dbconnect.php" ?>
    <?php include "partials/_header.php" ?>
    <?PHP
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }

    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {

        $th_title = mysqli_real_escape_string($connection, $_POST['threadtitle']);
        $th_desc = mysqli_real_escape_string($connection, $_POST['threaddesc']);
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);





        $sql = "INSERT INTO `threads` ( `thread_subject`, `thread_desc`, `thread_user_id`,`user_img`, `thread_cat_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$name','$profile' ,'$id', current_timestamp())";
        $result = mysqli_query($connection, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>thread created! </strong>Your thread successfully has been added!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        }
    }
    ?>
    <div class="container my-4">
        <div class="jumbotron jumbotron-custom">
            <h1 class="display-4">Welcome to <span class="text-primary"><?php echo $catname; ?></span> Forums</h1>
            <p class="lead">Connect with fellow coders and share your knowledge in this vibrant community.</p>
            <hr class="my-4">
            <p>This forum is dedicated to discussions on <span class="font-italic"><?php echo $catdesc; ?></span>. Please keep the discussions respectful and relevant.</p>
            <div class="rules">
                <h5 class="font-weight-bold">Common Rules:</h5>
                <ol>
                    <li>Do not post copyright-infringed materials.</li>
                    <li>Avoid spam and offensive content.</li>
                    <li>Be respectful of other members.</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <h4>
                <center>Post a question!</center>
                </h1>
                <div class="mb-3">
                    <label for="threadtitl" class="form-label">Thread Title</label>
                    <input type="text" class="form-control" id="threadtitle" name="threadtitle"
                        placeholder="keep your title short and crisp!">

                </div>
                <div class="mb-3">
                    <label for="threaddesc" class="form-label">Elaborate problem</label>
                    <textarea class="form-control" placeholder="Elaborate your problem here!" id="threaddesc"
                        name="threaddesc" style="height: 120px"></textarea>

                </div>

                <button type="submit" class="btn btn-success">Submit</button>
        </form>';
        } else {
            echo '<h5 style="color:green;">you are not logged in, using of account is mandatory to post something!</h5>';
        }

        ?>

        <br>
        <br>
        <h1 class="py-4">Browse Questions</h1>



        <?PHP
        $id = $_GET['catid'];


        $results_per_page = 10;

        $query = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result2 = mysqli_query($connection, $query);
        $number_of_result = mysqli_num_rows($result2);

        $number_of_page = ceil($number_of_result / $results_per_page);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $page_first_result = ($page - 1) * $results_per_page;




        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id LIMIT " . $page_first_result . ',' . $results_per_page;
        $result = mysqli_query($connection, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $thread_question = $row['thread_subject'];
            $thread_desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];

            echo '<div class="media my-3">
      <div style="display:flex;flex-direction:row;flex-wrap:wrap;">
<h5 class="mt-3"><a style="color:black;text-decoration:none;" href="thread.php?thread_id=' . $thread_id . '">Q) ' . $thread_question . '</a></h5>
      </div>
<div class="media-body">
<b>DESCRIPTION</b>  ' . $thread_desc . '
</div>
</div>';
        }
        if ($noResult) {
            echo '<div style="background-color:lightgrey;padding:15px;border-radius:20px;" class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">No threads Found!</h1>
          <p class="lead">Be the first one to ask a question.</p>
        </div>
      </div>';
        }

        ?>



        <br>


        <?php
        if ($number_of_result > 0) {
            echo '<nav class="res-pagination" aria-label="...">
            <div class="goleft">
    <i class="fa-solid fa-caret-left fa-bounce"></i>
    </div>
    <ul class="pagination pagination-lg triangle-pagination">';

            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<li class="page-item"><a class="page-link" href= "./thread_list.php?catid=' . $id . '&page=' . $page . '">' . $page . ' </a></li>';
            }

            echo '</ul>
            <div class="goright">
    <i class="fa-solid fa-caret-right fa-bounce"></i>
    </div>
    </nav>';
        }
        ?>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="assets/js/pagination.js"></script>
</body>

</html>