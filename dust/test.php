<?php

session_start();

$_SESSION["username"] = "yamada";
unset($_SESSION["username"]);
echo $_SESSION["username"];

// var_dump($_COOKIE["PHPSESSID"]);
// var_dump(session_id());

// echo session_id();

// echo session_name();

// session_regenerate_id();

// $_SESSION['products'] = array(
//     "ねぎま" => 80,
//     "はつ" => 90,
//     "かわ" => 70,
// );

// unset($_SESSION['products']);

// $_SESSION = array();

// print_r($_SESSION['products']);


?>