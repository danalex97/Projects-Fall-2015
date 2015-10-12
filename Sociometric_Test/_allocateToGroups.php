<?php
$kontor = 0;

while ($kontor < 10) {
++$kontor;

for ($i = 0; $i < $co; ++$i) {//each individual
    if ($belongsTo[ $friends[$i][1] ] == $belongsTo[ $friends[$i][2] ]
        and $belongsTo[ $friends[$i][1] ] != 0) {//P1 & P2 in same group AND not satellite group
        $influencedBy[$i] = $belongsTo[ $friends[$i][1] ];
    }else {
        if ($belongsTo[ $friends[$i][0] ] != 0) {//check if friend is a satellite; hopefully not
            $influencedBy[$i] = $belongsTo[ $friends[$i][0] ];
        }else {
            if ($belongsTo[ $friends[$i][1] ] != 0) {
                $influencedBy[$i] = $belongsTo[ $friends[$i][1] ];
            }else {
                $influencedBy[$i] = $belongsTo[ $friends[$i][2] ];
            }
        }
    }

    //now that we have found which group influences this individual
    //we must check if the group accepts him/her
    $sumPopularity = 0;//individual's popularity given by the group
    for ($j = 0; $j < $co; ++$j) {
        if ($belongsTo[$j] != $influencedBy[$i]) continue;
        for ($k = 0; $k < 3; ++$k) {
            if ($friends[$j][$k] == $i) {
                $sumPopularity += 3 - $k;//friends
            }
            if ($enemies[$j][$k] == $i) {
                $sumPopularity += $k - 3;//enemies
            }
        }

    }

    if ($sumPopularity > 0) {//gets accepted
        $belongsTo[$i] = $influencedBy[$i];
    }
}

}
?>
