<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include "_conect.php";

$sql = "select id,nume,prenume,sex,
         preferinta1,preferinta2,preferinta3,
         antipatie1,antipatie2,antipatie3
         from $clasa";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "eroare";
}

$id = array(); // id
$name = array(); // name
$popularity = array(); //  popularity
$gender = array(); //  gender
$friends = array(); // friends[3]
$enemies = array(); // enemies[3]
$belongsTo = array();//belongs to this group
$influencedBy = array();//in influenced by this group
$groupColor = array("DarkGrey", "Chartreuse", "Chocolate", "Crimson", "Green", "Salmon", "Violet", "DarkGrey", "Chartreuse", "Chocolate", "Crimson", "Green", "Salmon", "Violet");
$marked = array();
$auxG = array();
$xx = array();
$state = array();
$yy = array();

$co = 0; // number of students

for ($i = 0; $i < 50; ++$i) {
    $popularity[$i] = 0;
    $marked[$i] = 0;
    $auxG[$i] = 0;
}

while( $row = mysqli_fetch_assoc($result) )
{
    $id[$co] = $row["id"];
    $name[$co] = $row["nume"] . " " . $row["prenume"];
    //$popularity[$co] = 0;
    $state[ $co ] = 0;
    $belongsTo[ $co ] = 0;
    $influencedBy[ $co ] = 0;
    $gender[ $co ] = $row["sex"];
    $friends[$co] = array($row["preferinta1"],$row["preferinta2"],$row["preferinta3"]);
    $enemies[$co] = array($row["antipatie1"],$row["antipatie2"],$row["antipatie3"]);
    $x[$co] = 0;
    $y[$co] = 0;


        $popularity[$row["preferinta1"]] += 3;
        $popularity[$row["preferinta2"]] += 2;
        $popularity[$row["preferinta3"]] += 1;
        $popularity[$row["antipatie1"]] += -3;
        $popularity[$row["antipatie2"]] += -2;
        $popularity[$row["antipatie3"]] += -1;


    ++$co;
}

$component = 1;

$level = 0;//detects nuclei of 3<->3 relationships
include "_detectNuclei.php";

//for each individual, we see if we can attach them to a certain group
//1. see which group influences the individual
//*OBS: if there are two groups with an equal influence quotient, then we take
//the one which has (1 + 2) popularity instead of 3
//2. now check if that group accepts the individual, |received_popularity| > 0

include "_allocateToGroups.php";

$level = 1;
include "_detectNuclei.php";

include "_allocateToGroups.php";

//now that we have found the groups, print them in tables
for ($i = 0; $i < $co; ++$i) {
    ++$marked[ $belongsTo[$i] ];
}

$groupNumber = 0;

for ($i = 0; $i < $component; ++$i) {//rename groups from 0
    if ($marked[$i] != 0) {
        $auxG[$i] = $groupNumber;//old group ID points to new one
        ++$groupNumber;
    }
}

for ($i = 0; $i < $co; ++$i) {//delete one-person groups, and move them to the satellite group
    if ($marked[ $belongsTo[$i] ] == 1) {
        $marked[ $belongsTo[$i] ] = 0;
        $belongsTo[$i] = 0;
        --$groupNumber;

    }
}

for ($i = 0; $i < $co; ++$i) {
    /*if ($marked[ $belongsTo[$i] ] == 1) {
        $marked[ $belongsTo[$i] ] = 0;
        $belongsTo[$i] = 0;
    }*/
    $influencedBy[$i] = $auxG[ $influencedBy[$i] ];
    $belongsTo[$i] = $auxG[ $belongsTo[$i] ];
}


for ($i = 0; $i < $groupNumber; ++$i) {
    echo "<h1 style='color: #020C24'>";
    if ($i == 0) {//subtitles for each group
        echo "Grupul satelitilor";
    }else {
        echo "Grupul #$i";
    }
    echo "</h1>";
    echo "<table style='border: 3px solid $groupColor[$i]'>";
    echo "<tr><th>ID</th><th>Nume</th><th>Popularitate</th><th>Influentat de grupul #</th></tr>";
    for ($j = 0; $j < $co; ++$j) {
        if ($belongsTo[$j] == $i) {
            echo "<tr>";
            echo "<td>$id[$j]</td>";
            echo "<td>$name[$j]</td>";
            echo "<td>$popularity[$j]</td>";
            echo "<td>$influencedBy[$j]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}
?>
