<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>

<?php

$severname = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($severname,$username,$password);

if ( $conn === false )
{
    die("Connection failed:".mysqli_connect_error());
}

$database = "dummy";

$qry = "create database ".$database;
if ( mysqli_query($conn, $qry) === false )
{
    //echo "Error creating database: ".mysqli_error($conn);
}
mysqli_query($conn, "use $database");

/// Dummy colectiv import
echo "<p>";
echo "Numele colectivului: <br>";
echo "<form action=\"take_class.php\" method=\"post\">\n";
echo "  <td><input type=\"text\" name=\"nume_clasa\" placeholder=\"numele colectivului\">\n";
echo "<input type=\"submit\" value=\"Trimite\">\n </form>\n";
echo "</p>";
mysqli_close($conn);

?>
