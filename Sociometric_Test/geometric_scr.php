<html>

<!-- CODE BY CIURCA TUDOR && DAN ALEXANDRU -->
<!-- CONSULTANCY MURESAN BOGDAN -->
<!-- @2015 -->

<head>

    <style type="text/css">
        canvas {
            border: 1px solid black;
            float: left;
        }
        table {
            float: left;
        }
        .tdd td {
            border: outset #f4f4f2;
            background: #020C24;
            color: #f4f4f2;
        }
        .thh {
            border: outset #f4f4f2;
            background: #020C24;
            color: #f4f4f2;
            font-weight: bold;
        }
        .tdd2 td {
            background: #1253A4;
            border: outset #FF7672;
            color: #FF7672;
        }
    </style>

    <?php
        $width = 800;
        $height = 800;

        $x_center = $width/2;
        $y_center = $height/2;
        $r = $x_center;
        $step = 20; // $step/2 has to be even


        /* Make some associative arrays out of the files generated from the database
        We sould mentain for every person:
         1. id
         2. nume
         3. friend[3] // friend[0] is the best friend
         4. enemies[3]
         5. popularity
         6. gender

        We use popularity in order to create the sociometric target.
        */

        ///////////

$severname = "localhost";
$username = "root";
$password = "";

function load()
{
    $file = fopen("class_session","r");
    $token = fgets($file,1024);
    return $token;
}
$clasa = load();

$conn = mysql_connect($severname,$username,$password);

if ( $conn === false ) { die("Connection failed:".mysql_connect_error()); }

$database = "dummy";
mysql_query("use $database");

$sql = "select id,nume,prenume,sex,
         preferinta1,preferinta2,preferinta3,
         antipatie1,antipatie2,antipatie3
         from $clasa";
$result = mysql_query($sql,$conn);

$id = array(); // id
$name = array(); // name
$popularity = array(); //  popularity
$gender = array(); //  gender
$friends = array(); // friends[3]
$enemies = array(); // enemies[3]
$xx = array();
$state = array();
$yy = array();

$co = 0; // number of students

while( $row = mysql_fetch_assoc($result) )
{
    $id[$co] = $row["id"];
    $name[$co] = $row["nume"] . " " . $row["prenume"];
    $popularity[$co] = 0;
    $state[ $co ] = 0;
    $gender[ $co ] = $row["sex"];
    $friends[$co] = array($row["preferinta1"],$row["preferinta2"],$row["preferinta3"]);
    $enemies[$co] = array($row["antipatie1"],$row["antipatie2"],$row["antipatie3"]);
    $x[$co] = 0;
    $y[$co] = 0;

    //echo $id[ $co ]." ".$name[ $co ]." ".$popularity[ $co ]." ".$gender[ $co ]."<br>";
    ++$co;
}

//////////

        $clasa = array(
            "id" => $id ,
            "name" => $name ,
            "popularity" => $popularity ,
            "gender" => $gender ,
            "friends" => $friends ,
            "enemies" => $enemies ,
            "state" => $state ,
            "x" => $xx ,
            "y" => $yy
        );

        echo "<!-- ---------------------There is the whole list of the class.---------------- -->\n";

        echo "<table border = 1>\n";
        echo "<tr>\n";
            echo "<th class='thh'>ID</th><th class='thh'>Nume</th><th class='thh'>Sex</th>";
        echo "</tr>\n";
        echo "<tr class='tdd'> <td colspan=3 onclick=\"evo();\">Muta</td> </tr>";
        echo "<tr class='tdd'> <td colspan=3 onclick=\"reduce_step();\">Redu</td> </tr>";
        for ($i=0;$i<$co;++$i)
        {
            $id_now = $clasa["id"][$i];
            echo "<tr onclick=\" connect($id_now,this); \" id=\"student$id_now\" class='tdd'>\n";


            echo "  <td>".$clasa["id"][$i]."</td>\n";
            echo "  <td>".$clasa["name"][$i]."</td>\n";
            echo "  <td>".$clasa["gender"][$i]."</td>\n";

            echo "</tr>\n";
        }
        echo "<tr> <td colspan=3 onclick=\" clear_all(); \">Clear</td> </tr>";
        echo "</table>\n";

        echo "<!-- ------------------------------------------------------------------------- -->\n";

        /*$clasa = array(
            "friend" => array( array("id1","id2","id3") , array("id4","id5","id6") ) ,
            "varsta" => array("19","20")
        );*/
    ?>

    <script type="text/javascript">

        function change_tr_color(id,element) // changes the color of a row in table and the state of a student
        {
            var place = find_student_by_id(window.students,window.clasa,id);
            if ( window.clasa.state[place] == 0 )
            {
                element.className = 'tdd2';
                window.clasa.state[place] = 1;
            }
            else
            {
                element.className = 'tdd';
                window.clasa.state[place] = 0;
            }
        }

        function rotate_x(nowx,nowy,x,y,angle) // returns the x_coordonate of rotating the point (nowx,nowy) around (x,y) at some angle
        {
            nowx = nowx - x;
            nowy = nowy - y;

            var nextx = Math.cos(angle) * nowx - Math.sin(angle)* nowy;

            nowx = nowx + x;
            nowy = nowy + y;

            nextx = nextx + x;

            return nextx;
        }
        function rotate_y(nowx,nowy,x,y,angle)
        {
            nowx = nowx - x;
            nowy = nowy - y;

            var nexty = Math.sin(angle) * nowx + Math.cos(angle) * nowy;

            nowx = nowx + x;
            nowy = nowy + y;

            nexty = nexty + y;

            return nexty;
        }

        function gen_square(ctx,nowx,nowy,step) // GENERRATE SQUARE at coordinates (nowx,nowy) with edge length step/2
        {
            ctx.beginPath();
            var cx = nowx; var cy = nowy; var l = step/2;
            ctx.moveTo(cx,cy);
            ctx.moveTo(cx-l/2,cy-l/2);

            ctx.lineTo(cx+l/2,cy-l/2);
            ctx.lineTo(cx+l/2,cy+l/2);
            ctx.lineTo(cx-l/2,cy+l/2);
            ctx.lineTo(cx-l/2,cy-l/2);

            ctx.moveTo(cx,cy);
            ctx.stroke();
        }

        function gen_triangle(ctx,nowx,nowy,step) // GENERATE TRIANGLE at coordinates (nowx,nowy) with edge length step/2
        {
            ctx.beginPath();
            var cx = nowx; var cy = nowy; var l = step/2;

            var h = Math.sqrt(3) * l / 2;

            ctx.moveTo(cx,cy);
            ctx.moveTo(cx-h*2/3,cy);

            ctx.lineTo(cx+h/3,cy-l/2);
            ctx.lineTo(cx+h/3,cy+l/2);
            ctx.lineTo(cx-h*2/3,cy);

            ctx.moveTo(cx,cy);
            ctx.stroke();
        }

        function gen_circle(ctx,nowx,nowy,step) // GENERATE CIRCLE at coordonates (nowx,nowy) with edge depending to step
        {
            ctx.beginPath();
            ctx.moveTo(nowx+(step-14)/2,nowy);
            ctx.arc(nowx,nowy,(step-14)/2,0,Math.PI*2,true);
            ctx.moveTo(nowx,nowy);
            ctx.fill();
            ctx.stroke();
        }

        function draw_line(ctx,x1,y1,x2,y2,width,color) // draws a colored line with fixed width between (x1,y1) and (x2,y2)
        {
            ctx.beginPath();

            ctx.moveTo(x1,y1);
            ctx.lineTo(x2,y2);
            ctx.lineWidth = width; // line width , might add constant

            ctx.strokeStyle = color;
            ctx.stroke();

            ctx.strokeStyle = "black";
        }

        function compute_popularity(clasa,stundents) // computes popularity
        {
            for (var i = 0; i < stundents; ++i) {
                clasa.popularity[i] = 0;
            }
            for (var i = 0; i < students; ++i)
            {
                for (var j = 0; j < 3; ++j) {
                    clasa.popularity[clasa.friends[i][j]] += (3-j);
                }
                for (var j = 0; j < 3; ++j) {
                    clasa.popularity[clasa.enemies[i][j]] -= (3-j);
                }
            }
            return clasa;
        }

        function sort_by_popularity(clasa,students) // SORTING STRUCTURE clasa with fixed students
        {
            for (var i=0;i<students-1;++i)
                for (var j=i+1;j<students;++j)
                    if ( clasa.popularity[j] > clasa.popularity[i] )
                    {
                        // b = [a, a = b][0]; // swap(a,b)
                        clasa.popularity[j] = [ clasa.popularity[i] , clasa.popularity[i] = clasa.popularity[j] ][0];
                        clasa.id[j] = [ clasa.id[i] , clasa.id[i] = clasa.id[j] ][0];
                        clasa.name[j] = [ clasa.name[i] , clasa.name[i] = clasa.name[j] ][0];
                        clasa.friends[j] = [ clasa.friends[i] , clasa.friends[i] = clasa.friends[j] ][0];
                        clasa.enemies[j] = [ clasa.enemies[i] , clasa.enemies[i] = clasa.enemies[j] ][0];
                        clasa.gender[j] = [ clasa.gender[i] , clasa.gender[i] = clasa.gender[j] ][0];
                        clasa.state[j] = [ clasa.state[i] , clasa.state[i] = clasa.state[j] ][0];
                        clasa.x[j] = [ clasa.x[i] , clasa.x[i] = clasa.x[j] ][0];
                        clasa.y[j] = [ clasa.y[i] , clasa.y[i] = clasa.y[j] ][0];
                    }
            return clasa;
        }

        function find_student_by_id(students,clasa,ord) // finds the order of the student with the id "ord" in structure CLASA
        {
            var now_place = 0; // where is my students in the sorted array
            for (var i=0;i<students;++i)
                if ( ord == clasa.id[i] )
                    now_place = i;
            return now_place;
        }

        function connect(ord,element) // connects element on graphic
        {
            var now_place = find_student_by_id(students,clasa,ord);

            change_tr_color(ord,element);
            clear_table();

            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');

            var clasa = window.clasa;
            var students = window.students;

            for (var now_place=0;now_place<students;++now_place)
            {
                if ( clasa.state[now_place] == 0 )
                    continue;
                for (var i=0;i<3;++i)
                {
                    var friend_place = find_student_by_id(students,clasa,clasa.friends[now_place][i]);
                    draw_line(ctx,clasa.x[now_place],clasa.y[now_place],clasa.x[friend_place],clasa.y[friend_place],3-i,'blue');
                }
                for (var i=0;i<3;++i)
                {
                    var enemy_place = find_student_by_id(students,clasa,clasa.enemies[now_place][i]);
                    draw_line(ctx,clasa.x[now_place],clasa.y[now_place],clasa.x[enemy_place],clasa.y[enemy_place],3-i,'red');
                }
            }
        }

        function draw_circles(ctx) // DRAW CONCENTRIC CIRCLES
        // returns ir - i.e. the last place where the drawing stops
        {
            var x_center = parseInt('<?php print($x_center);?>');
            var y_center = parseInt('<?php print($y_center);?>');
            var r = parseInt('<?php print($r);?>');
            var step = parseInt('<?php print($step);?>');

            ctx.beginPath();
            var ir = r;
            for (;ir>0;ir-=step)
            {
                //ctx.arc(x_center,y_center,ir,0,Math.PI*2,true);
                var aux = x_center + ir - step;

                ctx.moveTo(aux,y_center);
            }
            ctx.stroke();
            return ir;
        }

        function clear_all() // clears all the lines and all the states
        {
            clear_table();
            for (var i=0;i<window.students;++i)
                window.clasa.state[i] = 0;
            var all = document.getElementsByTagName("tr");
            for (var i=0;i<all.length;++i)
                all[i].style.background = 'white';
        }

        function clear_table() //  clears all the lines , living the target empty
        {
            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');

            ctx.clearRect(0,0,1000,1000);

            var clasa = window.clasa;
            var students = window.students;
            var step = parseInt('<?php print($step);?>');

            draw_circles(ctx);

            for (var i = 0;i < students;++i)
                if ( clasa.gender[i] == 'M' )
                    gen_square(ctx,clasa.x[i],clasa.y[i],step);
                else
                    gen_circle(ctx,clasa.x[i],clasa.y[i],step);
        }

        function draw()
        {
            var canvas = document.getElementById('canvas');
            if (canvas.getContext)
            {
                var ctx = canvas.getContext('2d');

                var x_center = parseInt('<?php print($x_center);?>');
                var y_center = parseInt('<?php print($y_center);?>');
                var r = parseInt('<?php print($r);?>');
                var step = parseInt('<?php print($step);?>');

                var ir = draw_circles(ctx);

                // ----------CONVERTING AND SORTING STRUCTURE------------

                var clasa = <?php echo json_encode($clasa) ?>;
                students = parseInt('<?php print($co);?>');

                clasa = compute_popularity(clasa,students);
                clasa = sort_by_popularity(clasa,students);
                //for (var i=0;i<students;++i) alert( clasa.popularity[i] );

                // ------------------------------------------

                var sx = x_center;
                var sy = y_center;

                var last = 0;

                ir += step;
                //alert(students);

                sx = sx - ir - step/2; // go to second strip
                //alert(sx);
                sy = y_center;

                //alert(clasa);


                for (var i = 0;i <= students;++i)
                {
                    if ( clasa.popularity[i] != clasa.popularity[last] )
                    {
                        var nbr = i-last;
                        var angle = (Math.PI*2) / nbr;

                        var nowx = sx;
                        var nowy = sy;

                        // we will thake the start position as a random value on the circle

                        var random_angle = Math.random()*Math.PI*2;
                        var nextx = rotate_x(nowx,nowy,x_center,y_center,random_angle);
                        var nexty = rotate_y(nowx,nowy,x_center,y_center,random_angle);

                        nowx = nextx;
                        nowy = nexty;

                        for (var j=last;j<=i-1;++j)
                        {
                            clasa.x[j] = nowx;
                            clasa.y[j] = nowy;

                            //alert( clasa.x[j]);

                            var nextx = rotate_x(nowx,nowy,x_center,y_center,angle);
                            var nexty = rotate_y(nowx,nowy,x_center,y_center,angle);

                            nowx = nextx;
                            nowy = nexty;
                        }

                        sx -= step;
                        sy = y_center;

                        ir -= step;
                        last = i;
                    }
                }

                //alert("here");

                window.clasa = clasa;
                window.students = students;
                window.step = 0.3;

                for (var i = 0;i < students;++i)
                    if ( clasa.gender[i] == 'M' )
                        gen_square(ctx,clasa.x[i],clasa.y[i],step);
                    else
                        gen_circle(ctx,clasa.x[i],clasa.y[i],step);
            }
        }

         // In window iti sunt retinute students ( nr. elevi ) si clasa.

        // Ai structura clasa care contine :
        // - x
        // - y
        // - id
        // - name
        // - friends - 3 valori : 0 - cel mai bun , 1 , 2
        // - enemies - 3 valori : 0 - cel mai puternic,1,2


        function dist(clasa, i1, i2) {
            return Math.sqrt( (clasa.x[i1] - clasa.x[i2]) * (clasa.x[i1] - clasa.x[i2]) + (clasa.y[i1] - clasa.y[i2]) * (clasa.y[i1] - clasa.y[i2]) );
        }

        function score(clasa, index) {
            var total = 0;
            var poz = []; poz.push(5); poz.push(3); poz.push(2);
            var neg = []; neg.push(-3/2); neg.push(-2/2); neg.push(-1/2);
            //var neg = []; neg.push(0); neg.push(0); neg.push(0);
            for(var i = 0; i < 3; i++) {
                var indexfr = find_student_by_id(students,clasa,clasa.friends[index][i]);
                //var indexfr = 0;
                total += ( 100 / dist(clasa, index, indexfr) ) * poz[i];
            }
            for(var i = 0; i < 3; i++) {
                var indexdus = find_student_by_id(students,clasa,clasa.enemies[index][i]);
                //var indexdus = 0;
                total += ( 100 / dist(clasa, index, indexdus) ) * neg[i];
            }
            return total;
        }

        function pdist(x,y,x2,y2)
        {
            return Math.sqrt( (x-x2) * (x-x2) + (y-y2) * (y-y2) );
        }

        function zgood(clasa,co,idx,x,y)
        {
            for (var i=0;i<co;++i)
                if ( i != idx )
                    if ( pdist(x,y,clasa.x[i],clasa.y[i]) < 3 )
                        return 0;
            return 1;
        }

        function reduce_step()
        {
            //window.step -= 10;
            window.step -= 1;
        }

        function bogdi()
        {
            var clasa = window.clasa;
            var students = window.students;

            var modul = window.step;

            var directii = 8;
            var dir = [];
            dir.push({x:0,y:1});
            dir.push({x:1,y:1});
            dir.push({x:1,y:0});
            dir.push({x:1,y:-1});
            dir.push({x:0,y:-1});
            dir.push({x:-1,y:-1});
            dir.push({x:-1,y:0});
            dir.push({x:-1,y:1});

           //alert("manele");
           //alert(dist(clasa,0,1));
           // alert( score(clasa,0) );

            for (var i = 0; i < students; i++)
            {
                var bestscore = score(clasa, i);
                var xbest = clasa.x[i];
                var ybest = clasa.y[i];
                var old = bestscore;
                bestscore = 0;
                for (var j = 0; j < directii; j++) {
                    var mod_now = Math.sqrt( dir[j].x * dir[j].x + dir[j].y * dir[j].y );
                    var xnow = clasa.x[i] + ( dir[j].x / mod_now ) * modul;
                    var ynow = clasa.y[i] + ( dir[j].y / mod_now ) * modul;

                    if ( xnow < 0 || xnow > 800 ) continue;
                    if ( ynow < 0 || ynow > 800 ) continue;

                    var backupx = clasa.x[i];
                    var backupy = clasa.y[i];

                    clasa.x[i] = xnow;
                    clasa.y[i] = ynow;

                    var snow = score(clasa,i) - old;

                    clasa.x[i] = backupx;
                    clasa.y[i] = backupy;

                    if ( snow > bestscore )
                    {
                        bestscore = snow;
                        xbest = xnow;
                        ybest = ynow;
                    }
                }

                if ( zgood(clasa,students,i,xbest,ybest) )
                {
                    clasa.x[i] = xbest;
                    clasa.y[i] = ybest;
                }
            }

            //var dir = {(0,1),(1,1),(1,0),(1,-1),(0,-1),(-1,-1),(-1,0),(-1,1)};
            //var pos = find_student_by_id(students,clasa,clasa.friends[0][0]);

            return clasa;
        }

        function evo()
        {
            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');

            ctx.clearRect(0,0,1000,1000);

            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');
            var step = parseInt('<?php print($step);?>');

            clasa = window.clasa;
            students = window.students;

            for (var i=0;i<20;++i)
            {
               // alert("xxx");
                clasa = bogdi();
            }
            window.clasa = clasa;

            for (var i = 0;i < students;++i)
                if ( clasa.gender[i] == 'M' )
                    gen_square(ctx,clasa.x[i],clasa.y[i],step);
                else
                    gen_circle(ctx,clasa.x[i],clasa.y[i],step);

            for (var now_place=0;now_place<students;++now_place)
            {
                if ( clasa.state[now_place] == 0 )
                    continue;
                for (var i=0;i<3;++i)
                {
                    var friend_place = find_student_by_id(students,clasa,clasa.friends[now_place][i]);
                    draw_line(ctx,clasa.x[now_place],clasa.y[now_place],clasa.x[friend_place],clasa.y[friend_place],3-i,'blue');
                }
                for (var i=0;i<3;++i)
                {
                    var enemy_place = find_student_by_id(students,clasa,clasa.enemies[now_place][i]);
                    draw_line(ctx,clasa.x[now_place],clasa.y[now_place],clasa.x[enemy_place],clasa.y[enemy_place],3-i,'red');
                }
            }
        }

        document.addEventListener("DOMContentLoaded", init, false);

        function init()
        {
            var canvas = document.getElementById("canvas");
            canvas.addEventListener("mousedown", getPosition, false);
        }

        function access_student(sx,sy)
        {
            var the_id = -1;

            var student = window.students;
            var clasa = window.clasa;
            for (var i=0;i<student;++i)
            {
                var pl = find_student_by_id(student,clasa,i);
                if ( (clasa.x[pl] - sx) * (clasa.x[pl] - sx) + (clasa.y[pl] - sy) * (clasa.y[pl] - sy) <= 10 )
                    the_id = i;
            }

            if (  the_id != -1 )
            {
                var the_element = "student" + the_id;
                connect(the_id,document.getElementById(the_element));

                var canvas = document.getElementById("canvas");
                var ctx=canvas.getContext("2d");
                ctx.fillText(clasa.name[find_student_by_id(student,clasa,the_id)],sx,sy);
            }

        }

        function getPosition(event)
        {
            var x = new Number();
            var y = new Number();
            var canvas = document.getElementById("canvas");

            if ( event.x != undefined && event.y != undefined)
            {
                x = event.x;
                y = event.y;
            }
            else
            {
                x = event.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
                y = event.clientY + document.body.scrollTop + document.documentElement.scrollTop;
            }

            x -= canvas.offsetLeft;
            y -= canvas.offsetTop;

            access_student(x,y);
        }

    </script>

</head>

<body onload="draw();">
    <canvas id="canvas" width="800" height="800"></canvas>
</body>

</html>
