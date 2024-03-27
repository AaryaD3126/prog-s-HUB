<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'partials/_dbconnect.php';
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    $search_query = htmlspecialchars($_GET['search']); 
   
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>search results -
        <?php

        echo $search_query;

        ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body{
            font-family: 'Chivo Mono', monospace;

        }
        #maincontainer {
            min-height: 100vh;
        }
        <?php include "assets/css/_header.css"; ?>

    </style>
</head>

<body>
    <?php include "partials/_dbconnect.php" ?>
    <?php include "partials/_header.php"; ?>

    <div class="container my-3" id="maincontainer">
        <h1 class="py-3">Search results for <em>"<?php echo $search_query; ?>"
            </em></h1>
        <?php
         $results_per_page = 10;  
  
 $query = "SELECT * FROM threads WHERE MATCH(thread_subject, thread_desc) AGAINST ('$search_query')";
         $result2 = mysqli_query($connection, $query);  
         $number_of_result = mysqli_num_rows($result2);  
       
         $number_of_page = ceil ($number_of_result / $results_per_page);  
       
         if (!isset ($_GET['page']) ) {  
             $page = 1;  
         } else {  
             $page = $_GET['page'];  
         }  
       
         $page_first_result = ($page-1) * $results_per_page;
         $result_found = false;
$sql = "SELECT * FROM threads WHERE thread_subject LIKE '%$search_query%' OR thread_desc LIKE '%$search_query%' LIMIT ". $page_first_result . ',' . $results_per_page;
       
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $result_found = true;
        
            echo ' <div class="result mx-5">
    <h3><a href="./thread.php?thread_id=' . $row['thread_id'] . '" class="text-dark">' . $row['thread_subject'] . '</a> </h3>
    <p>' .  $row['thread_desc'] . '</p>
</div>  ';
        }
        if (!$result_found) {
            echo '<div style="background-color:lightgrey;padding:15px;" class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No threads found for your search results!</h1>
              <p class="lead"> Suggestions: <ul>
              <li>Make sure that all words are spelled correctly.</li>
              <li>Try different keywords.</li>
              <li>Try more general keywords. </li></ul>
      </p>
            </div>
          </div>';
        }
        ?>

<br>
<?php
    if ($number_of_result > 0) {
        echo '<nav aria-label="...">
<ul class="pagination pagination-lg">
 
';

        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<li class="page-item"><a class="page-link" href= "./search.php?search=' . $search_query . '&page=' . $page . '">' . $page . ' </a></li>';
        }
        echo '</ul>
</nav>';
    }

    ?>
    <br><br>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>