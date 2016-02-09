<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

$class_now = $_POST["go"];

$file = fopen("class_session","w");
fwrite($file,$class_now);
fclose($file);

echo "<p>A fost ales colectivul: $class_now </p>"."<br>";

?>
