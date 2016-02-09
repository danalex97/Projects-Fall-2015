<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

if ( $_POST["elev_sters"] != null )
{
    $vl = $_POST["elev_sters"];
    $qry = "delete from $clasa where id = $vl";

    if ( $_POST["elev_sters"] != "" ) if ( mysqli_query($conn, $qry) === false ) echo "error delete";
}

mysqli_close($conn);

if ( $_POST["elev_sters"] != "" )
    echo "<p>Elevul a fost sters cu succes.</p>";
else
    echo "<p>Nu a fost selectata stergerea unui elev.</p>";
?>

<html>
    <iframe src="print_table.php" width="600" height="600"> </iframe>
</html>
