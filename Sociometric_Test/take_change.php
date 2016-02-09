<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

if ( $_POST["elev"] != null )
{
    $id = $_POST["elev"];
    $nume = $_POST["nume"];
    $pren = $_POST["pren"];
    $sex = $_POST["sex"];
    //echo $id."<br>";
    $qry = "update $clasa set nume = '$nume' where id = $id";
    if ( $_POST["nume"] != "" ) if ( mysqli_query($conn,$qry) === false ) echo "error change";
    $qry = "update $clasa set prenume = '$pren' where id = $id";
     if ( $_POST["pren"] != "" ) if ( mysqli_query($conn,$qry) === false ) echo "error change";
    $qry = "update $clasa set sex = '$sex' where id = $id";
    if ( $_POST["sex"] != "" ) if ( mysqli_query($conn,$qry) === false ) echo "error change";
}

mysqli_close($conn);

if ( $_POST["elev"] != "" )
    echo "<p>Schimbarile au fost facute cu succes.</p>";
else
    echo "<p>Nu a fost selectat niciun elev.</p>";
?>

<html>
    <iframe src="print_table.php" width="600" height="600"> </iframe>
</html>
