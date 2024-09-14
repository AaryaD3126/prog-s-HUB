<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die("<h2>Access Denied!</h2> This file is protected and not available to the public.");
}
?>
<nav style="z-index:1;" class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <span style="font-weight: bold; font-size: 24px;">Prog's HUB</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="chatroom.php">Community Chat</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link active" href="contact.php">Contact</a>
                </li>
            </ul>
            <form action="./search.php" method="get" class="d-flex" role="search">
                <input class="form-control me-2" name="search" type="search" placeholder="Search a thread" aria-label="Search a thread">
                <button class="btn-custom btn-primary me-2" type="submit"><div>
<i class="fa-solid fa-magnifying-glass fa-beat-fade"></i>
</div></button>
            </form>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                if (isset($_SESSION['profile'])) {
                    $profile = $_SESSION['profile'];
                    echo '<img class="mx-2" src="' . $profile . '" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">';
                } else {
                    echo '
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <button type="submit" class="btn-custom btn-outline-light" style="border-radius: 50px; width: fit-content; height:fit-content;background-color:#007bff;"><i class="fa-solid fa-plus fa-beat" style="color: #ffffff;"></i></button>
                        </form>';
                }
                echo '<p style="font-size: 16px; color: white;" class="mx-2 my-1">' . $_SESSION["username"] . '</p>';
                echo '<form action="./partials/logout.php" method="post"><button class="btn-custom btn-outline-danger my-1" data-bs-toggle="modal" data-bs-target="#signupmodal">Log Out</button></form>';
            } else {
                echo '<button class="btn-custom btn-outline-success mx-2 my-1" data-bs-toggle="modal" data-bs-target="#loginmodal">Log In</button>';
                echo '<button class="btn-custom btn-outline-success my-1" data-bs-toggle="modal" data-bs-target="#signupmodal">Sign Up</button>';
            }
            ?>
        </div>
    </div>
</nav>

<?php
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Account created!</strong> Your account is successfully created. You can now log in!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>
