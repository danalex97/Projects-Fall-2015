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

function print_options($name_to_id,$name)
{
    echo "<select name=\"$name\">";
    foreach ($name_to_id as $name => $id)
        echo "<option value=\"$id\">$name</option>";
    echo "</select><br>";
}

echo "<h3>Selectati elevul destinat schimbarii de date personale:</h3>";
echo "<form action=\"take_change.php\" method=\"post\">\n";
print_options($name_to_id,"elev");
echo "<p>";
echo "Nume : <input type=\"text\" name=\"nume\" placeholder=\"nume\"><br>\n";
echo "Prenume : <input type=\"text\" name=\"pren\" placeholder=\"prenume\"><br>\n";
echo "Sex : <input type=\"text\" name=\"sex\" placeholder=\"sex\"><br>\n";
echo "<input type=\"submit\" value=\"Trimite\">\n";
echo "</form>";
echo "</p>";

?>
