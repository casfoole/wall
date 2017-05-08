<?php
session_start();
if(!isset($_SESSION["username"])){
    exit(); }
?>
<!DOCTYPE html>
<head>
    <link rel="icon" href="img/prisma.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<p class="gebruiker"><a href="profile.php">@<?php echo $_SESSION['username']; ?></a></p>
<div class="wrapper">
    <a href="index.php"><img src="img/prisma.png" alt="logo" class="logo"></a>
</div>
<div class="wrapper">
    <ul class="nav">
        <li><a href="index.php"> Home </a></li>
        <li><a href="upload.php"> Upload </a></li>
        <li><a href="profile.php"> Profile </a></li>

    </ul>
</div>
<hr>
<div class="wrapper">
    <div class="login">
        <center>
<h1> PROFILE</h1>
            <p class="name">Username: <?php echo $_SESSION['username']; ?></p>
            <br><br><br>
            <a href="logout.php">Logout</a>
        </center>


    </div>
    <br>
</div>
</body>
</html>