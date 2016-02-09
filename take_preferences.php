<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$qry = "select count(*) from $clasa";
$res = mysqli_fetch_assoc(mysqli_query($conn,$qry));
$students = $res['count(*)'];
$qry1 = $qry2 = $qry3 = $qrya1 = $qrya2 =  $qrya3 = 0;
for ($i=0;$i<$students;++$i)
    //if ( $_POST["id_p1_$i"] != null )
    {
        $act_p1 = "";
        $act_p2 = "";
        $act_p3 = "";
        $act_a1 = "";
        $act_a2 = "";
        $act_a3 = "";
        if ( $_POST["id_p1_$i"] != null ) $act_p1 = $_POST["id_p1_$i"];
        if ( $_POST["id_p2_$i"] != null ) $act_p2 = $_POST["id_p2_$i"];
        if ( $_POST["id_p3_$i"] != null ) $act_p3 = $_POST["id_p3_$i"];
        if ( $_POST["id_a1_$i"] != null ) $act_a1 = $_POST["id_a1_$i"];
        if ( $_POST["id_a2_$i"] != null ) $act_a2 = $_POST["id_a2_$i"];
        if ( $_POST["id_a3_$i"] != null ) $act_a3 = $_POST["id_a3_$i"];

        $qryp1 = "update $clasa set preferinta1 = $act_p1 where id = $i";
        $qryp2 = "update $clasa set preferinta2 = $act_p2 where id = $i";
        $qryp3 = "update $clasa set preferinta3 = $act_p3 where id = $i";
        $qrya1 = "update $clasa set antipatie1 = $act_a1 where id = $i";
        $qrya2 = "update $clasa set antipatie2 = $act_a2 where id = $i";
        $qrya3 = "update $clasa set antipatie3 = $act_a3 where id = $i";

        if ( $_POST["id_p1_$i"] != "" ) if ( mysqli_query($conn,$qry1) === false ) echo "error p1";
        if ( $_POST["id_p2_$i"] != "" ) if ( mysqli_query($conn,$qry2) === false ) echo "error p2";
        if ( $_POST["id_p3_$i"] != "" ) if ( mysqli_query($conn,$qry3) === false ) echo "error p3";
        if ( $_POST["id_a1_$i"] != "" ) if ( mysqli_query($conn,$qrya1) === false ) echo "error a1";
        if ( $_POST["id_a2_$i"] != "" ) if ( mysqli_query($conn,$qrya2) === false ) echo "error a2";
        if ( $_POST["id_a3_$i"] != "" ) if ( mysqli_query($conn,$qrya3) === false ) echo "error a3";
    }

mysqli_close($conn);

?>

<html>
    <iframe src="print_table.php" width="600" height="600"> </iframe>
</html>
