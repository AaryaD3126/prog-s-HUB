<?php
session_start();
?>
<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo '<script>alert("Login first!");</script>';
    echo '<script>window.location="./index.php";</script>';
}
?>
<?php
$roomname = $_GET['roomname'];

include "db_connect.php";

$sql = "SELECT * FROM `rooms` WHERE roomname = '$roomname'";
$result = mysqli_query($connection, $sql);

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        $message = "This room does not exist, try creating a new one";
        echo '<script language="javascript">';
        echo 'alert("' . $message . '");'; // Not showing an alert box.
        echo 'window.location="./chatroom.php";';
        echo '</script>';
    }
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chatroom: <?php echo $roomname; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Chivo Mono', monospace;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;

        }

        .msgcontainer {
  -ms-overflow-style: none; /* for Internet Explorer, Edge */
  scrollbar-width: none; /* for Firefox */
  overflow-y: scroll; 
}

.msgcontainer::-webkit-scrollbar {
  display: none; /* for Chrome, Safari, and Opera */
}
        .main {
            padding: 40px 20px;
            background-color: #1a1a1a;
            box-shadow:20px 27px 6px rgba(0, 0, 0, 0.5);
            width: 80vw;
            margin: 20px auto;
        }

        .container {
            border: 2px solid #dedede;
            background-color: #1a1a1a;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0px;
            width: 80%!important;
        }

        .darker {
            border-color: #ccc;
            background-color: #333;
        }

        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        .time-right {
            float: right;
            color: #007bff;
        }

        .msgcontainer {
            height: 450px;
            overflow-y: scroll;
        }

        #link {
            width: 100%;
            background-color: #1a1a1a;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 18px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
        #usermsg{
            width: 60vw;
        }
        .input-box{
            display: flex;
            flex-direction: row;
            gap: 10px;
            justify-content: center;
        }
        #submitmsg{
            width: 20vw;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    ?>

    <?php include "partials/_header.php" ?>

    <div class="main">
      <div style="display:flex;flex-direction:row;flex-wrap:wrap;justify-content:center;align-self:center;align-items:center;gap:20px;">
        <h2 style="color:#007bff;">ROOM NAME: <span style="color:white;"><?php echo $roomname; ?></span></h2>
        <input id="link" style="display:none;" type="text" value="<?php echo $url; ?>" disabled>
        <button onclick="copyLink()">Copy Link</button>
      </div>
        <div class="msgcontainer">
            <div class="container">

            </div>
        </div>
<div class="input-box">
        <input type="text" class="form-control" name="usermsg" id="usermsg" placeholder="Add message">
        <button class="btn btn-secondary" name="submitmsg" id="submitmsg">Send</button>
    </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        setInterval(runFunction, 1000);

        function runFunction() {
            $.post("htcont.php", { room: '<?php echo $roomname ?>' },
                function (data, status) {
                    document.getElementsByClassName('msgcontainer')[0].innerHTML = data;
                    $(".container").fadeIn(1000); // Fade in animation for new messages
                })
        }

        var input = document.getElementById("usermsg");

        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("submitmsg").click();
            }
        });

        $("#submitmsg").click(function () {
            var clientmsg = $("#usermsg").val();
            $.post("postmsg.php", {
                text: clientmsg, room: '<?php echo $roomname ?>', IP: '<?php echo $_SERVER['REMOTE_ADDR'] ?>'
            },
                function (data, status) {
                    document.getElementsByClassName('msgcontainer')[0].innerHTML = data;
                    $(".container").fadeIn(1000); // Fade in animation for new messages
                });
            $("#usermsg").val("");
            return false;
        });

        function copyLink() {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(copyText.value);

            alert("Copied the room link: " + copyText.value);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <br><br>
    <?php include "partials/_footer.php" ?>
</body>

</html>
