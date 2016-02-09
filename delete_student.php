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
    echo "</select>";
}

echo "<p>Selectati elevul destinat stergerii:</p> ";
echo "<form action=\"take_delete.php\" method=\"post\">\n";
print_options($name_to_id,"elev_sters");
echo "<input type=\"submit\" value=\"Trimite\">\n";
echo "</form>";

?>
