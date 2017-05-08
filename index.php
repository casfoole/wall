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
    <link rel="stylesheet" type="text/css" href="jsStyle.css">
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
<center>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input type="text" name="searchterm" placeholder="zoeken"/>
        <input type="submit" name="submit_search" value="zoeken"/>
    </form>
    <form method="post" action="<?php echo $_SERVER['PHP_self']; ?>">
        <select name="sorteermenu">
            <option value="date_asc">Datum oplopend</option>
            <option value="date_desc">Datum aflopend</option>
            <option value="descr_asc">Beschrijving oplopend</option>
            <option value="descr_desc">Beschrijving aflopend</option>
        </select>
        <input type="submit" name="submit_sort" value="sorteren"/>
    </form>
    <?php
    $column = 'date';
    $order = 'DESC';

    if(isset($_POST['submit_sort'])) {
        switch ($_POST['sorteermenu']) {
            case  'date_asc': $column = 'date';
                $order = 'ASC';
                break;
            case  'date_desc': $column = 'date';
                $order = 'DESC';
                break;
            case  'descr_asc': $column = 'onderschrift';
                $order = 'ASC';
                break;
            case  'descr_desc': $column = 'onderschrift';
                $order = 'DESC';
                break;
        }}
    ?>
    <?php
    if (isset($_POST['submit_search'])){
        $searchterm = mysqli_real_escape_string($dbc,trim($_POST['searchterm']));
        $searchterm = '%' . $_POST['searchterm'] . '%';
    } else {
        $searchterm = '%';
    }
    ?>
</center>
<div class="wrapper">

    <form class="feed">
        <br>
        <center>
        </center>
        <div id="uitvoer">

        </div>
    </form>

</div>
<?php
require_once ("connectvars.php");
$dbc = mysqli_connect(HOST,USER,PASS,DBNAME) or die ('Error3!');


$record = "SELECT * FROM images WHERE onderschrift LIKE '$searchterm' ORDER  BY $column $order" or die('mysqli_error()');
$result2 = mysqli_query($dbc, $record);
$list = array();
while($row = mysqli_fetch_array($result2)){
    $list[] = $row['target'];
}


$cart_info_json = json_encode($list);

?>
<script>

    var alleAfb = JSON.parse('<?= $cart_info_json; ?>');

    var uitvoer = document.getElementById('uitvoer');
    const TotaleBreedte = uitvoer.clientWidth;
    var teller = 0;
    var tijdelijkeBreedte = 0;
    const UitgangsHoogte = 120;


    function wisselArray(arr) {
        var nieuweArray = [];
        while (arr.length>0) {
            var rndm = Math.floor(Math.random()*arr.length);
            var element = arr.splice(rndm, 1);
            nieuweArray.push(element);
        }

        return nieuweArray;
    }
    alleAfb = wisselArray(alleAfb);

    function maakRij() {
        var element = document.createElement('div');
        element.className = 'rij';
        uitvoer.appendChild(element);
    }
    function zoekDeRij(){
        var element = document.getElementsByClassName('rij');
        return element[0];
    }


    function maakPlaatje(num) {
        var afbeelding = document.createElement('img');
        afbeelding.src =  alleAfb[num];
        afbeelding.alt = 'foto' + num;
        return afbeelding;
    }

    function nieuweHoogte(getal) {
        var gewensteHoogte = UitgangsHoogte*TotaleBreedte/getal;
        return gewensteHoogte + 'px';
    }
    function voegPlaatjeToe(num) {
        afb = maakPlaatje(num);
        var rij = zoekDeRij();
        rij.appendChild(afb);
        afb.addEventListener('load', function() {
            tijdelijkeBreedte =+ afb.clientWidth;
            if(tijdelijkeBreedte >= TotaleBreedte ) {
                rij.className = 'klaar';
                rij.style.height = nieuweHoogte(tijdelijkeBreedte);
                maakRij();
                tijdelijkeBreedte = 0;
            }
            teller ++;
            if(teller<alleAfb.length) {
                voegPlaatjeToe(teller);
            }
        });
    }
    maakRij();
    voegPlaatjeToe(0);

    document.getElementById('meer').addEventListener('click', function(){
        alleAfb = wisselArray(alleAfb);
        teller = 0;
        voegPlaatjeToe(0);
    })




</script>
</body>
</html>