<?php

include ("_conect.php");

$qry = "select count(*) from $clasa";
$res = mysql_fetch_assoc(mysql_query($qry,$conn));
$students = $res['count(*)'];

for ($i=0;$i<30;++$i)
    if ( $_POST["nume$i"] != null )
    {
        $act_name = $_POST["nume$i"];
        $act_pren = $_POST["pren$i"];
        $act_sex = $_POST["sex$i"];
        /*$qry = "insert into $clasa (id,nume,prenume,sex,
          preferinta1,preferinta2,preferinta3,antipatie1,antipatie2,antipatie3)
          values ($students,$act_name,$act_pren,$act_sex,0,0,0,0,0,0)";*/
        $qry = "insert into $clasa (id,nume,prenume,sex) values ($students,\"$act_name\",\"$act_pren\",\"$act_sex\")";
        if ( mysql_query($qry,$conn) === false )
        {
            echo "Error: " . $qry . "<br>" . mysql_error($conn);
        }
        $students++;
    }

mysql_close($conn);

?>

<html>
    <iframe src="print_table.php" width="600" height="600"> </iframe>
</html>
