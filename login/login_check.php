<?php

$mail = $_POST['mail'];
$pass = $_POST['pass'];

// echo $mail;
// echo $pass;

try
{
    
    $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user ,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $sql = 'SELECT * FROM signup WHERE mail=?';
    // $stmt = $db->prepare($sql);
    // $stmt->execute(array($mail));
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $result = $stmt->fetch();

    //prepareメソッドでSQLをセット
    $stmt = $dbh->prepare("SELECT * FROM signup WHERE mail = :mail");

    //bindValueメソッドでパラメータをセット
    $stmt->bindValue(':mail', $mail);

    //executeでクエリを実行
    $stmt->execute();

    //結果を表示
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // var_dump($result);

    // echo '<br>';
    // echo $result['pass'];

    if(!$result) {
        session_start();
        $_SESSION['error'] = '該当するデータがありません';
        header('Location: /login');
        // echo '該当するデータがありません';
        exit;
    }


    if($result['pass'] === $pass) {
        session_start();
        $_SESSION['name'] = $result['name'];
        $_SESSION['id'] = $result['id'];
        header('Location: /');
    } else {
        session_start();
        $_SESSION['error'] = '入力が正しくありません';
        header('Location: /login');
        // echo '入力が正しくありません';
        // exit;
    }

   


    $dbh = null;


}catch (Exception $e)
{
    echo $e->getMessage();

};












?>