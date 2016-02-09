<html>
     <head>
        <title> Test sociometric </title>
        <link rel="stylesheet" href="style3.css" type="text/css">
    </head>
</html>

<?php
    $user = "dummy";
    echo "<div class='container'>\n";
    echo "  <p style='color: white;'> Utilizator: $user </p>\n";
    echo "</div>\n";
?>

<html>

    <script type="text/javascript">
        function load_stuff(page)
        {
            window.location.href = "http://localhost/meniu_page.php?stuff=" + page;
        }
    </script>

    <body>

        <div class="header">
            <h1 class="title"> Test Sociometric </h1>
        </div>

        <div class="sidebar" align="center">
            <table class="sidetable">
                <tr> <td onclick="load_stuff('new_class.php');"> <b>Creati colectiv nou</b> </td> </tr>
                <tr> <td onclick="load_stuff('load_table.php');"> <b>Importare colectiv</b> </td> </tr>
                <tr> <td onclick="load_stuff('copy_table.php');"> <b>Copiere colectiv</b> </td> </tr>
                <tr> <td onclick="load_stuff('insert_table.php');"> <b>Introducerea unor elevi in colectivul actual</b> </td> </tr>
                <tr> <td onclick="load_stuff('delete_student.php');"> <b>Stergerea unui elev din colectivul actual</b> </td> </tr>
                <tr> <td onclick="load_stuff('change_data.php');"> <b>Modificarea datelor personale ale unor elevi</b> </td> </tr>
                <tr> <td onclick="load_stuff('insert_preferences.php');"> <b>Modificarea preferintelor colectivului actual</b> </td> </tr>
                <tr> <td onclick="load_stuff('print_table.php');"> <b>Afisarea colectivului actual</b> </td> </tr>
                <tr> <td onclick="load_stuff('print_matrix.php');"> <b>Afisarea matricei sociometrice a colectivului actual </b> </td> </tr>
                <tr> <td onclick="load_stuff('print_standings.php');"> <b>Afisarea clasamentului de popularitate al colectivului </b> </td> </tr>
                <tr> <td onclick="load_stuff('sociometric_target.php');"> <b>Afisarea tintei sociometrice a colectivului actual</b> </td> </tr>
                <tr> <td onclick="load_stuff('geometric_scr.php');"> <b>Simulator</b> </td> </tr>
                <tr> <td onclick="load_stuff('detectGroups.php');"> <b>Detecteaza grupuri</b> </td> </tr>
            </table>
        </div>

        <?php

        if ( isset($_GET['stuff']) )
            $now = $_GET['stuff'];
        else
            $now = "welcome.php";

        echo "<div class=\"content\">";
        echo "<iframe src=\"$now\" class=\"frame\" width=1140 height=1000> </iframe>";
        echo "</div>";

        ?>

        <div class="footer">
            <p class="ftext"> Soft realizat de Ciurca Tudor si Dan Alexandru. Contact: dan.alex97@yahoo.com </p>
        </div>

    </body>

</html>
