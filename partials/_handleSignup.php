<?php
// Block direct access to this file
 if ($_SERVER[''] === 'GET' && realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'])) {
     header('HTTP/REQUEST_METHOD1.0 403 Forbidden', true, 403);
     die("<h2>Access Denied!</h2> This file is protected and not available to public.");
}

$showError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '_dbconnect.php';

    // Escape and sanitize input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $c_password = filter_var($_POST['c_password'], FILTER_SANITIZE_STRING);

    // Check if any fields are blank
    if (empty($username) || empty($password) || empty($c_password)) {
        $showError = 'Please fill in all fields.';
    } else {
        // Check if username is alphanumeric
        if (!ctype_alnum($username)) {
            $showError = 'Please enter an alphanumeric username.';
        } else {
            // Check if username is already in use
            $existsSQL = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($connection, $existsSQL);
            if (mysqli_num_rows($result) > 0) {
                $showError = 'This username is already in use.';
            } else {
                // Check if username and password meet length requirements
                if (strlen($username) < 3 || strlen($username) > 30) {
                    $showError = 'Please enter a username between 3 and 30 characters.';
                } else if (strlen($password) < 8 || strlen($password) > 30) {
                    $showError = 'Please enter a password between 8 and 30 characters.';
                } else {
                    // Check if passwords match
                    if ($password !== $c_password) {
                        $showError = 'Passwords do not match.';
                    } else {
                        // Hash password and insert new user into database
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users (username, password, timestamp) VALUES ('$username', '$hash', current_timestamp())";
                        $result = mysqli_query($connection, $sql);
                        if ($result) {
                            header('Location: ../index.php?signupsuccess=true');
                            exit();
                        } else {
                            $showError = 'An error occurred while creating your account.';
                          
                        }
                    }
                }
            }
        }
    }
    
}
echo '<script>alert("'.$showError.'");</script>';

    echo '<script>window.location = "../index.php?signupsuccess=false&error='.$showError.'";</script>';


?>

