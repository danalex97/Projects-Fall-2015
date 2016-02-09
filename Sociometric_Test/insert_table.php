<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

echo "<p> Inserare colectiv: </p>\n";
echo "<table  border=solid>\n
        <form action=\"take_table.php\" method=\"post\">\n";

echo "<tr> <th>Id</th> <th>Nume</th> <th>Prenume</th> <th>Sex</th> </tr>\n";

for ($i=0;$i<30;++$i)
{
    echo "<tr>\n";
    echo "  <td>$i</td>\n";
    echo "  <td><input type=\"text\" name=\"nume$i\" placeholder=\"nume\">\n";
    echo "  <td><input type=\"text\" name=\"pren$i\" placeholder=\"pren\">\n";
    echo "  <td><input type=\"text\" name=\"sex$i\" placeholder=\"sex\">\n";
    echo "</tr>\n";
}

echo "<input type=\"submit\" value=\"Trimite\">\n
        </form></table>\n";


?>
