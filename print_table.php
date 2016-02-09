<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$sql = "select id,nume,prenume,sex,preferinta1,preferinta2,preferinta3,antipatie1,antipatie2,antipatie3 from $clasa order by nume,prenume";
$result = mysqli_query($conn, $sql);

if ( mysqli_num_rows($result) > 0 )
{
    echo " <table> \n";
    echo "<tr> <th>Id</th> <th>Nume</th> <th>Prenume</th> <th>Sex</th>
            <th> P1 </th> <th> P2 </th>  <th> P3 </th>
            <th> A1 </th> <th> A2 </th>  <th> A3 </th>
            </tr>\n";
    while( $row = mysqli_fetch_assoc($result) )
    {
        echo "<tr>\n";
        echo "  <td>".$row["id"]."</td>\n";
        echo "  <td>".$row["nume"]."</td>\n";
        echo "  <td>".$row["prenume"]."</td>\n";
        echo "  <td>".$row["sex"]."</td>\n";
        echo "  <td>".$row["preferinta1"]."</td>\n";
        echo "  <td>".$row["preferinta2"]."</td>\n";
        echo "  <td>".$row["preferinta3"]."</td>\n";
        echo "  <td>".$row["antipatie1"]."</td>\n";
        echo "  <td>".$row["antipatie2"]."</td>\n";
        echo "  <td>".$row["antipatie3"]."</td>\n";
        echo "</tr>\n";
    }
    echo " </table> \n";
} else {
    echo "0 results";
}

mysqli_close($conn);

?>
