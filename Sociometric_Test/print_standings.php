<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$sql = "select id,nume,prenume,sex,preferinta1,preferinta2,preferinta3,antipatie1,antipatie2,antipatie3 from $clasa order by nume,prenume";
$result = mysqli_query($conn, $sql);

if ( mysqli_num_rows($result) > 0 )
{

    $id_to_name = array( -1 => "0" );
    $id_to_popularity = array( -1 => -1 );
    $co = 0;

    for ($i=0;$i<60;++$i) $id_to_popularity[$i] = 0;

    while( $row = mysqli_fetch_assoc($result) )
    {
        $id_to_name[ $row["id"] ] = $row["nume"]." ".$row["prenume"];
        if ( $row["preferinta1"] ) $id_to_popularity[$row["preferinta1"]] += 3;
        if ( $row["preferinta2"] ) $id_to_popularity[$row["preferinta2"]] += 2;
        if ( $row["preferinta3"] )$id_to_popularity[$row["preferinta3"]] += 1;
        if ( $row["antipatie1"] ) $id_to_popularity[$row["antipatie1"]] += -3;
        if ( $row["antipatie2"] ) $id_to_popularity[$row["antipatie2"]] += -2;
        if ( $row["antipatie3"] ) $id_to_popularity[$row["antipatie3"]] += -1;
        ++$co;
    }

    $ord = array();
    for ($i=0;$i<$co;++$i)
        $ord[$i] = $i;

    function my_sort($ord,$assoc,$co)
    {
        for ($i=0;$i<$co;++$i)
            for ($j=0;$j<$co;++$j)
                if ( $assoc[$ord[$i]] > $assoc[$ord[$j]] )
                {
                    $ord[$i] ^= $ord[$j] ^= $ord[$i] ^= $ord[$j];
                }
        return $ord;
    }

    $ord = my_sort($ord,$id_to_popularity,$co);

    echo "<table>\n";
    echo "  <tr>  ";
    echo "<th>Elev</th>  ";
    echo "<th>Popularitate</th>  ";
    echo "  <tr>\n";
    for ($j=0;$j<$co;++$j)
    {
        echo " <tr> ";
        echo "<td>".$id_to_name[$ord[$j]]."</td>  ";
        echo "<td>".$id_to_popularity[$ord[$j]]."</td>  ";
        echo "  <tr>\n";
    }
    echo "</table>";
}

mysqli_close($conn);

?>
