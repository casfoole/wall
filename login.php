<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="img/prisma.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
    <title> Login</title>
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
</head>
<body>
<center>
    <img src="img/prisma.png" alt="logo" class="logo">
<h1> Je moet inloggen voor je de site kan betreden.</h1>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <p id="username">Username</p>
        <input type="text" name="username"/>
        <br>
        <p id="ww" >Wachtwoord</p>
        <input type="text" name="wachtwoord"/>
        <br><br>
        <input name="submit" type="submit" value="aanmelden"/><br />
    </form>
    <br/><a id='nope' href='registreren.php.php'>Klik hier om te registreren</a></div>

</center>
<?php
require('connectvars.php');
$dbc = mysqli_connect(HOST,USER,PASS,DBNAME) or die ('Error2!');
session_start();
if (isset($_POST['username'])){
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($dbc,$username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($dbc,$password);
    $query = "SELECT * FROM gebruiker WHERE username='$username'
        and password='".md5($password)."'";
    $result = mysqli_query($dbc,$query) or die('nope connect');
    $rows = mysqli_num_rows($result);
    if($rows==1){
        echo "gelukt";
        header('location: '."index.php");
        $_SESSION['username'] = $username;
    }else{
        echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a id='nope' href='inlog.php'>Login</a></div>";
    }
}else{}
?>
</body>
</html>