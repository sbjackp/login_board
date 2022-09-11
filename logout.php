<?php
    // session_start();
    // $_SESSION = array();

    function logout_func(){
        session_start();
        $_SESSION = array();
        session_destroy();
    }
    logout_func();

    header('Location: /');
    exit;


?>


    <!-- <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <a href="/">TOPへ</a>
    </body>
    </html> -->
    