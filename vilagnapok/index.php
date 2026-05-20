<?php

header('Content-Type: application/json; charset=utf-8;');  //ez kötelező az api elejére

$database = mysqli_connect("localhost", "root", "", "vilagnapok");

if (!$database) {

    die("Hiba");
}

$honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];

if (!empty($_GET["nap"])) {


    $datum = explode("-", $_GET["nap"]);
    $honap = $datum[0];
    $nap = $datum[1];

    $lekerdezes = mysqli_query($database, "SELECT * FROM vilagnapok WHERE nap = '$nap' AND honap = '$honap' ");

    if (mysqli_num_rows($lekerdezes) > 0) {

        $valasz = mysqli_fetch_assoc($lekerdezes);
        $tomb = [
            "datum" => $honapok[$valasz["honap"] -1] . " " . $valasz["nap"],
            "esemeny1" => $valasz["esemeny1"],
            "esemeny2" => $valasz["esemeny2"]
        ];
        print json_encode($tomb);
        // print_r(mysqli_fetch_assoc($lekerdezes));
    } else {
        $tomb = ["hiba" => "Nincs találat"];
        print json_encode($tomb);
    }
}





elseif (!empty($_GET["esemeny"])) {

    // "datum":"március 8.","esemeny1":"Nemzetközi nőnap","esemeny2":"A nők jogainak napja"


    $esemeny = $_GET["esemeny"];

    $lekerdezes = mysqli_query($database, "SELECT * FROM vilagnapok WHERE esemeny1 = '$esemeny' OR esemeny2 = '$esemeny' LIMIT 1");


    if (mysqli_num_rows($lekerdezes) > 0) {

        $valasz = mysqli_fetch_assoc($lekerdezes);
        $tomb = [
            "datum" => $honapok[$valasz["honap"] -1] . " " . $valasz["nap"],
            "esemeny1" => $valasz["esemeny1"],
            "esemeny2" => $valasz["esemeny2"]
        ];
        print json_encode($tomb);

    }

    else{
        $tomb = [
            "minta1" => "/?nap=12-25",
            "minta2" => "/?esemeny=Karácsony"
        ];
        print json_encode($tomb);

    }
    mysqli_close($database);
}



?>