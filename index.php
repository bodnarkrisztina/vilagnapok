<?php

session_start();
if (isset($_POST["leadas"])) {

    $nap = $_POST["nap"];
    $esemeny = $_POST["esemeny"] ?? '';

    $link = "http://localhost/PHP%20gyakorlások/vilagnapok/API/vilagnapok";

    $atadas = "";

    if (!empty($esemeny)) {
        $atadas = "?esemeny=" . urlencode($esemeny);

    }
    if (!empty($nap)) {
        $atadas = "?nap=" . urlencode($nap);

    }

    $osszefuzz = $link . $atadas;
    $meghivas = file_get_contents($osszefuzz);

    $tomb = json_decode($meghivas, true);
    $_SESSION["valasz"] = $tomb;
    // var_dump($tomb);

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            margin: 10px;
            font-size: 14px;

        }

        @media (min-width: 768px) {
            body {
                flex-direction: row;
                margin: 40px;
                font-size: 18px;
                gap: 30px;
            }

        }
    </style>

</head>

<body>

    <form action="index.php" method="post">

        <label for="nap"> Ide add meg a dátumot</label>
        <input type="text" name="nap" placeholder="pl. 2-2">

        <br>


        <label for="esemeny"> Ide add meg az eseményt</label>
        <input type="text" name="esemeny" placeholder="pl. Nutella nap">


        <input name="leadas" type="submit" value="Leadás">






    </form>
    <div id="output">
        <?php
        if (isset($_SESSION["valasz"])) {
            $valasz = $_SESSION["valasz"];
            unset($_SESSION["valasz"]);

            if (isset($valasz["hiba"])) {
                echo '<strong> Hiba: </strong>' . $valasz['hiba'] . "<br>";

            } elseif (isset($valasz["minta1"])) {
                echo '<strong> minta1: </strong>' . $valasz['minta1'] . "<br>";
                echo '<strong> minta2: </strong>' . $valasz['minta2'] . "<br>";
            }
            else {
            echo '<strong> dátum: </strong>' . $valasz['datum'] . "<br>";

            echo '<strong> esemény1: </strong>' . $valasz['esemeny1'] . "<br>";

            echo '<strong> esemény2: </strong>' . $valasz['esemeny2'] . "<br>";
            }
        }

        ?>

</body>

</html>