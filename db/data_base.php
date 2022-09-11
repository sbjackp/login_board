<?php

function db(){
    try {
        $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user ,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        return $dbh;
    
    } catch (Exception $e) {
        echo $e->getMessage ();
    
        // 更新書き込みを防ぐ
        // echo 'ただいま障害により大変ご迷惑をお掛けしております。 ';
        exit();
    }
}





