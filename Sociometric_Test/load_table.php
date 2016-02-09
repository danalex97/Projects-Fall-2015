<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

$severname = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($severname,$username,$password);

if ( $conn === false ) { die("Connection failed:".mysqli_connect_error()); }

$database = "dummy";
mysqli_query($conn, "use $database");

$sql = "show tables";
$result = mysqli_query($conn, $sql);

$options = array( 0 );
while( $row = mysqli_fetch_array($result) )
{
    $options[++$options[0]] = $row[0];
}

echo "<form action=\"take_load.php\" method=\"post\">\n";
echo "<select name=\"go\">\n";

for ($i=1;$i<=$options[0];++$i)
{
    echo "  <option value=\"$options[$i]\"> $options[$i] </option>";
}

echo "</select>\n";
echo "<input type=\"submit\" value=\"Trimite\">\n </form>";

mysqli_close($conn);

?>

<html>

</html>
