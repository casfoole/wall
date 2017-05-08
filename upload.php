<?php
session_start();
if(!isset($_SESSION["username"])){
    exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="img/prisma.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<p class="gebruiker"><a href="profile.php">@<?php echo $_SESSION['username']; ?>
    </a></p>
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

    <div class="wrapper">

        <div class="login">
            <center>
                <br>
                <br>
                <form enctype="multipart/form-data" method="post" action="upload.php">
                    <!--        <input type="hidden" name="MAX_FILE_SIZE" value="32768"/>-->
                    <input type="file" name="pick_file" id="pick_file" value="Pick file">
                    <br>
                    <label for="onderschrift">Omschrijving</label><br>
                    <textarea name="onderschrift" id="onderschrift" rows="4" cols="30" placeholder="description"></textarea><br>
                    <input type="submit" name="submit" class="button" value="Upload"/>
                </form>
            </center>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    require_once('connectvars.php');
    $dbc = mysqli_connect(HOST,USER,PASS,DBNAME) or die ('Error!');
    $onderschrift = mysqli_real_escape_string($dbc, trim($_POST['onderschrift']));
    $target = 'img/' . time() . $_FILES['pick_file']['name'];
    $temp = $_FILES['pick_file']['tmp_name'];
    if (!empty($onderschrift)) {
        if (move_uploaded_file($temp,$target)) {
            echo '<br>Gelukt!<br>';
            $query = "INSERT INTO images VALUES (0,NOW(),'$onderschrift','$target','$username')";
            $result = mysqli_query($dbc, $query) or die('Error querying.');
            header('location: '."index.php");

        } else {
            echo '<br>Mislukt!.<br>';
        }

    }
}
?>
</body>
</html>