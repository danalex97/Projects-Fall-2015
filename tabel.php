<html>
<head>
    <title>tema tabel</title>
</head>

<body>
    <?php
        $fin = fopen("tabel.csv", "r");
        $data = array();
        $average = 0.0;
        $cnt = 0;
        //echo var_dump($average);
        echo "<table border = 1>";
        echo "<tr>";
        echo "<th>Nr.</th> <th>Nume</th> <th>Mate</th> <th>Bio</th> <th>Sport</th> <th>Media</th> <th>Data nasterii</th>";
        echo "</tr>";
        while ( !feof($fin) ) {
            $cnt++;
            $data = explode(",", fgets($fin));
            //echo var_dump($data[0]);
            $average = ($data[2] + $data[3] + $data[4]) / 3;
            $year = "19".$data[0][1].$data[0][2];
            $month = $data[0][3].$data[0][4];
            $day = $data[0][5].$data[0][6];
            //echo $average."<br>";
            echo "<tr>";
            echo "<td>$cnt</td> <td>$data[1]</td> <td>$data[2]</td> <td>$data[3]</td> <td>$data[4]</td> <td>$average</td> <td>$day.$month.$year</td>";
            echo "</tr>";
        }
        echo "</table>";
        fclose($fin);
    ?>
</body>
</html>
