<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="img/prisma.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
    <style>
        body {
            background-color: white;
            font-family: 'Share Tech Mono', monospace;

        }
        img
        {
            width: 100%;
            height:100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            width: 200px;
        }
        a
        {
            text-decoration: none;
            color: black;

        }
        a:hover
        {
            text-decoration: underline;
            color: black;
        }
    </style>
    <meta charset="utf-8" lang="nl">
</head>
<body>
<center>
    <img src="img/prisma.png" alt="logo" class="logo">
    <h1> Registreren </h1>
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <br>
        <p id="user">Username</p>
        <input type="text" name="username"/>
        <br>

        <p id="ww" >Wachtwoord</p>
        <input type="text" name="wachtwoord"/>
        <br>

        <p id="wwagain" >Wachtwoord</p>
        <input type="text" name="wachtwoordagain"/>
        <br>

        <p id="email">Email</p>
        <input type="text" name="email"/>
        <br><br>
        <input type="submit" name="submit" class="button" value="registreer"/>
    </form>
    <a href="login.php"> Klik hier om in te loggen </a>
</center>
<?php
require_once ("connectvars.php");
$dbc = mysqli_connect(HOST,USER,PASS,DBNAME) or die ('Error2!');
$password = mysqli_real_escape_string($dbc,(trim($_POST['password'])));
$hashed_password = hash('md5',$password);
$random_number = rand(1000,9999);
$hashcode = hash('md5',$random_number);
$username = mysqli_real_escape_string($dbc,(trim($_POST['username'])));
$email = mysqli_real_escape_string($dbc,(trim($_POST['email'])));


$query = "INSERT INTO gebruiker
    VALUES (0,'$username','$hashed_password','$email','$hashcode',0)";
$result = mysqli_query($dbc,$query) or die ('');
$subject = $_POST['subject'];
$message = 'welkom dit is verificatie'.
    'klik op de link om te verivieren'.
    'link=' . $email . '$hashcode=' . $hashcode;

$from = '22937@ma-web.nl';

$query = "SELECT FROM gebruiker
    WHERE email='$email' AND hashcode='$hashcode'";
$result = mysqli_query($dbc,$query) or die ('');
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);
    $userid = $row['userid'];
    $query = "UPDATE 22937_carl SET status=1 WHERE userid='$userid'";
    $result = mysqli_query($dbc,$query) or die ('Error updating');
    echo '<br>Bedankt, je bent nu ingeschreven.';
    header('location: '."login.php");

}

while($row = mysqli_fetch_array($result)) {
    $to = $row['email'];
    echo 'while';
    mail($to,$subject,$message,'From:' . $from);
    echo "Mail vertuurtd naar " . $to . '<br>';
}
?>