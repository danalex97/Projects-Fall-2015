<?php
//detect all nuclei of 2 and 3
for ($i = 0; $i < $co; ++$i) {//nucleus of 2
    for ($j = 0; $j < $co; ++$j) {
        if ($friends[$i][$level] == $j and
            $friends[$j][$level] == $i and
            $belongsTo[$i] == 0) {

            $belongsTo[$i] = $belongsTo[$j] = $component++;

        }

    }

}

for ($i = 0; $i < $co; ++$i) {//nucleus of 3
    for ($j = 0; $j < $co; ++$j) {
        for ($k = 0; $k < $co; ++$k) {
            if ($friends[$i][$level] == $j and
                $friends[$j][$level] == $k and
                $friends[$k][$level] == $i and
                $belongsTo[$i] == 0)
                {
                $belongsTo[$i] = $belongsTo[$j] = $belongsTo[$k] = $component++;
            }
        }
    }

}
?>
