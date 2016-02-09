<html>

<head>

    <?php
        $width = 800;
        $height = 800;

        $x_center = $width/2;
        $y_center = $height/2;
        $r = $x_center;
        $step = 50;

        /* Make some associative arrays out of the files generated from the database
        We sould mentain for every person:
         1. id - natural numbers
         2. nume
         3. friends [3] - given by ids
         4. enemies [3] - given by ids
         5. popularity
         6. gender

        We use popularity in order to create the sociometric target

        Observation : could make just 3 friends , 3 enemies , for simplicity.
        Observation2 : it would be better to make an object that can be sorted and sheet.
        */

        $name = array(); // id => name
        $popularity = array(); // id => popularity
        $gender = array(); // id => gender

        $F = fopen("data.txt","r");

        while ( !feof($F) )
        {
            $row = fgets($F);
            $row_data = explode(',',$row);

            //for ($i=0;$i<4;++$i) echo $row_data[$i].' ';

            $name[ $row_data[0] ] = $row_data[1];
            $popularity[ $row_data[0] ] = $row_data[2];
            $gender[ $row_data[0] ] = $row_data[3];
        }

    ?>

    <script type="text/javascript">
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
            var cx = nowx; var cy = nowy; var l = step/2;
            ctx.moveTo(cx,cy);
            ctx.moveTo(cx-l/2,cy-l/2);

            ctx.lineTo(cx+l/2,cy-l/2);
            ctx.lineTo(cx+l/2,cy+l/2);
            ctx.lineTo(cx-l/2,cy+l/2);
            ctx.lineTo(cx-l/2,cy-l/2);

            ctx.moveTo(cx,cy);
        }

        function gen_triangle(ctx,nowx,nowy,step) // GENERRATE TRIANGLE at coordinates (nowx,nowy) with edge length step/2
        {
            var cx = nowx; var cy = nowy; var l = step/2;

            var h = Math.sqrt(3) * l / 2;

            ctx.moveTo(cx,cy);
            ctx.moveTo(cx-h*2/3,cy);

            ctx.lineTo(cx+h/3,cy-l/2);
            ctx.lineTo(cx+h/3,cy+l/2);
            ctx.lineTo(cx-h*2/3,cy);

            ctx.moveTo(cx,cy);
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

                //alert(x);alert(y);alert(r);alert(step);

                // DRAW CONCENTRIC CIRCLES

                ctx.beginPath();
                for (var ir = r;ir>0;ir-=step)
                {
                    ctx.arc(x_center,y_center,ir,0,Math.PI*2,true);
                    var aux = x_center + ir - step;

                    ctx.moveTo(aux,y_center);
                }

                // -------------------------

                var sx = x_center;
                var sy = y_center;

                /******** TESTING AREA *************/

                //var parser = '<?php foreach ($popularity as $key => $value) echo $key,' '; ?>'; // read ids
                //var ids = new Array();
                //for (var i=0;i<;++i)

                var popularity = <?php echo json_encode($popularity) ?>; // no quotes
                // creates a structure popularity which has the memebers all the ids
                alert(popularity.DA1);
                //alert(ids);

                /************************************/

                for (var ir=r;ir>0;ir-=step)
                {
                    var nbr = Math.floor((Math.random() * 15) + 1);
                    // for test purposes take a random number of students up to 15

                    var angle = (Math.PI*2) / nbr;

                    var nowx = sx;
                    var nowy = sy;

                    // we will thake the start position as a random value on the circle

                    var random_angle = Math.random()*Math.PI*2;
                    var nextx = rotate_x(nowx,nowy,x_center,y_center,random_angle);
                    var nexty = rotate_y(nowx,nowy,x_center,y_center,random_angle);

                    nowx = nextx;
                    nowy = nexty;

                    for (var i=1;i<=nbr;++i)
                    {

                        if ( i % 2 == 0 )
                            gen_square(ctx,nowx,nowy,step);
                        else
                            gen_triangle(ctx,nowx,nowy,step);

                        var nextx = rotate_x(nowx,nowy,x_center,y_center,angle);
                        var nexty = rotate_y(nowx,nowy,x_center,y_center,angle);

                        nowx = nextx;
                        nowy = nexty;
                    }

                    if ( ir == r )
                    {
                        sx = sx - (3*step)/2;
                        sy = y_center;
                    }
                    else
                    {
                        sx -= step;
                        sy = y_center;
                    }
                }

                ctx.stroke();
            }
        }
    </script>
    <style type="text/css">
        canvas {
            border: 1px solid black;
        }
    </style>

</head>

<body onload="draw();">
    <canvas id="canvas" width="800" height="800"></canvas>
</body>

</html>
