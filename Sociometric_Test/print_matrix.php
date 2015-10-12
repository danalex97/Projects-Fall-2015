<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$sql = "select id,nume,prenume,sex,preferinta1,preferinta2,preferinta3,antipatie1,antipatie2,antipatie3 from $clasa order by nume,prenume";
$result = mysqli_query($conn,$sql);

if ( mysqli_num_rows($result) > 0 )
{
    $id_to_name = array( -1 => "0" );
    include("_matrix.php");
    $co = 0;
    while( $row = mysqli_fetch_assoc($result) )
    {
        $id_to_name[ $row["id"] ] = $row["nume"]." ".$row["prenume"];
        $matrix[$row["id"]][$row["preferinta1"]] = 3;
        $matrix[$row["id"]][$row["preferinta2"]] = 2;
        $matrix[$row["id"]][$row["preferinta3"]] = 1;
        $matrix[$row["id"]][$row["antipatie1"]] = -3;
        $matrix[$row["id"]][$row["antipatie2"]] = -2;
        $matrix[$row["id"]][$row["antipatie3"]] = -1;
        ++$co;
    }

    function format_it($input)
    {
        $output = "";
        $spaces = 0;
        for ($i=0;$i<strlen($input);++$i)
        {
            if ( $input[$i] == ' ' )
                $spaces++;
            $output .= $input[$i];
            if ( $spaces == 1 )
            {
                $output .= $input[$i+1];
                $output .= '.';
                break;
            }
        }
        return $output;
    }

    function modify($input)
    {
        $output = "";
        $spaces = 0;
        for ($i=0;$input[$i]!='.';++$i)
        {
            $output .= $input[$i];
            $output .= "<br>";
        }
        return $output;
    }

    echo "<table>\n";
    echo "  <tr>  ";
    echo "<th></th>  ";
    for ($j=0;$j<$co;++$j)
        echo "<th>".modify(format_it($id_to_name[$j]))."</th>  ";
    echo "<tr>\n";
    for ($i=0;$i<$co;++$i)
    {
        echo "  <tr>  ";
        echo "<td>".format_it($id_to_name[$i])."</td>  ";
        for ($j=0;$j<$co;++$j)
            echo "<td>".$matrix[$i][$j]."</td>  ";
        echo "<tr>\n";
    }
    echo "</table>\n";
}

mysqli_close($conn);

?>
