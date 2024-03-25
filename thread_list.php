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
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Chivo Mono', monospace;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .jumbotron {
            border-radius: 20px;
            background: #dee2e6;
            padding: 40px;
        }

        .lead {
            font-size: 24px;
        }

        ol {
            font-size: 18px;
        }

        .container.my-4 {
            border-radius: 20px;
        }

        .form-control,
        .btn-success {
            font-family: 'Chivo Mono', monospace;
            font-size: 18px;
        }

        .py-4 {
            color: #343a40;
        }

        .media {
            border: 1px solid #adb5bd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
        }

        .page-link {
            color: #343a40;
        }

        .page-item.active .page-link {
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-outline-secondary {
            color: #343a40;
            border-color: #343a40;
        }

        .btn-outline-secondary:hover {
            background-color: #343a40;
            color: #fff;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 15px 0;
            text-align: center;
        }

        .jumbotron-custom {
            background-color: #343a40;
            color: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .jumbotron-custom h1,
        .jumbotron-custom h5 {
            color: #17a2b8;
        }

        .jumbotron-custom p {
            font-size: 18px;
        }

        .rules {
            margin-top: 20px;
        }

        .rules ol {
            padding-left: 20px;
        }

        .rules ol li {
            font-size: 16px;
        }
        .pagination {
    margin: 20px 0;
    display: flex;
    justify-content: center;
    list-style: none;
    background: linear-gradient(to right, #4CAF50, #008CBA); /* Gradient background */
    padding: 10px;
    border-radius: 20px; /* Rounded corners */
}

.page-item {
    margin: 0 5px;
}

.page-link {
    padding: 8px 16px;
    background-color: transparent;
    border: none;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease;
    background-color: rgba(255, 255, 255, 0.2); /* Transparent background on hover */

}



.page-link:focus {
    outline: none;
    box-shadow: none;
}

.page-link.active {
    background-color: rgba(255, 255, 255, 0.2); /* Transparent background for active page */
}

/* Animation effect */
.page-item {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Triangle effect */
.triangle-pagination::before {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid white; /* Triangle pointing upwards */
}

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
    echo '<nav aria-label="...">
    <ul class="pagination pagination-lg triangle-pagination">';

    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<li class="page-item"><a class="page-link" href= "./thread_list.php?catid=' . $id . '&page=' . $page . '">' . $page . ' </a></li>';
    }
    
    echo '</ul>
    </nav>';
}
?>


    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php include "partials/_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>