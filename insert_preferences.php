<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$sql = "select id,nume,prenume from $clasa";
$result = mysqli_query($conn, $sql);
$id_to_name = array( "" => "" );
$name_to_id = array( "" => "" );
while( $row = mysqli_fetch_assoc($result) )
{
    $id_now = $row["id"];
    $nume = $row["nume"];
    $pren = $row["prenume"];

    $nume_comp = $nume." ".$pren;

    $id_to_name[$id_now] = $nume_comp;
    $name_to_id[$nume_comp] = $id_now;
}

$sql = "select id,nume,prenume,sex from $clasa";
$result = mysqli_query($conn, $sql);

function print_options($name_to_id,$name,$i)
{
    echo "<td>";
    echo "<select name=\"$name\">";
    foreach ($name_to_id as $name => $id)
        echo "<option value=\"$id\">$name</option>";
    echo "</select>";
    echo "</td>";
}

if ( mysqli_num_rows($result) > 0 )
{
    echo "<p> Inserare relatii: </p>\n";
    echo "<table>\n
        <form action=\"take_preferences.php\" method=\"post\">\n";
    echo " <table border=solid> \n";
    echo "<tr> <th>Id</th> <th>Nume</th> <th>Prenume</th> <th>Sex</th>
        <th>Pref1</th> <th>Pref2</th> <th>Pref3</th>
        <th>Anti1</th> <th>Anti2</th> <th>Anti3</th> </tr>\n";
    $i = 0;
    while( $row = mysqli_fetch_assoc($result) )
    {
        echo "<tr>\n";
        echo "  <td>".$row["id"]."</td>\n";
        echo "  <td>".$row["nume"]."</td>\n";
        echo "  <td>".$row["prenume"]."</td>\n";
        echo "  <td>".$row["sex"]."</td>\n";
        print_options($name_to_id,"id_p1_".$i,$i);
        print_options($name_to_id,"id_p2_".$i,$i);
        print_options($name_to_id,"id_p3_".$i,$i);
        print_options($name_to_id,"id_a1_".$i,$i);
        print_options($name_to_id,"id_a2_".$i,$i);
        print_options($name_to_id,"id_a3_".$i,$i);
        echo "</tr>\n";
        ++$i;
    }
    echo "<input type=\"submit\" value=\"Trimite\">\n
        </form></table>\n";
} else {
    echo "0 results";
}

mysqli_close($conn);

?>

<html>

</html>
