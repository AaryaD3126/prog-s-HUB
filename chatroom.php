<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $name = $_SESSION["username"];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prog's HUB - CHATROOM</title>
    <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/901d7d049c.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Chivo Mono', monospace;
            background: linear-gradient(to bottom right, #2c2c2c, #343a40, #343a40, #2c2c2c);
            color:white;
        }

        .jumbotron-custom {
            color: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .jumbotron-custom h1 {
            color: #ffffff;
        }

        .jumbotron-custom p {
            font-size: 18px;
            text-align: left;
        }

        .btn-outline-custom {
            border-color: #ffffff;
            color: #ffffff;
        }

        .btn-outline-custom {
            background-color: black;
            color: #17a2b8;
        }

        .list-group-item-custom {
            font-size: 20px;
            text-decoration: none;
            color: #007bff;
        }

        .list-group-item-custom:hover {
            color: #ffffff;
        }

        .list-group-custom {
            border-radius: 10px;
        }
        <?php include "assets/css/_header.css"; ?>
    </style>
</head>

<body>
    <?php include "partials/_header.php"; ?>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-5 text-center">
        <div class="col-md-13 p-lg-5 mx-auto my-5">
            <h1 class="display-4 fw-normal">My Chat Room</h1>
            <div style="text-align: left;">
                <ul>
                    <li>
                        <p class="my-5 lead fw-normal">Create a chat room and share it with your community/friends to interact and collaborate with them anonymously.</p>
                    </li>
                    <li>
                        <p class="my-5 lead fw-normal">These are publicly accessible, but it will keep your user identity anonymous.</p>
                    </li>
                    <li>
                        <p class="my-5 lead fw-normal">Share your chatroom URL with others to invite them!</p>
                    </li>
                </ul>
            </div>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo '<form style="width:100%;" action="claim.php" method="post">
                        <div>
                            Enter room name:  <input type="text" name="room">
                            <button class="btn btn-outline-custom" href="#">Claim Room</button>
                        </div>
                    </form>';
                include "db_connect.php";
                $sql = "SELECT * FROM rooms WHERE room_by = '$name'";
                $result = mysqli_query($connection, $sql);

                echo '<ul class="list-group list-group-custom container my-2">
                        <li class="list-group-item active">Your Rooms</li>';
                $noResult = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noResult = false;
                    echo '<li class="list-group-item">
                            <a class="list-group-item-custom" target="_blank" href="./rooms.php?roomname=' . $row['roomname'] . '">
                                ' . $row["roomname"] . '
                            </a>
                        </li>';
                }
                if ($noResult) {
                    echo '<li class="list-group-item">No room created by your account yet!</li>';
                }
                echo '</ul>';
            } else {
                echo '<p style="color:green;font-weight:bolder;font-size:18px;">Log in to create a chatroom!</p>';
            }
            ?>
        </div>
        <div></div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device produt-device-2 shadow-sm d-none d-md-block"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
