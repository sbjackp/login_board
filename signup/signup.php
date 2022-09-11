<?php

$data = $_POST['data'];

header("Content-type: application/json; charset=UTF-8");
//JSONデータを出力
// echo json_encode($_POST);
// exit;




// 困ったらjsonでどこまで来てるか確認
// echo json_encode($data['mail']);
// exit;

// error_log ('$task: ' . print_r (mb_strlen($data), true));
// exit;
// ターミナルでエラーログを見る
// tail -f php_error.log

try
{
    
    if(mb_strlen($data['name']) === 0){
        $status = [
            'status' => 'error',
            'message' => 'B名前を入力して下さい'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    } elseif(mb_strlen($data['name']) >= 10){
        $status = [
            'status' => 'error',
            'message' => 'B名前は10文字以内で入力して下さい'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    }

    if(mb_strlen($data['mail']) === 0){
        $status = [
            'status' => 'error',
            'message' => 'Bメールアドレスを入力して下さい'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    } elseif(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)){
        $status = [
            'status' => 'error',
            'message' => 'メールアドレスを正しい形式で入力して下さい'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    }

    if(mb_strlen($data['pass']) === 0){
        $status = [
            'status' => 'error',
            'message' => 'Bパスワードを入力して下さい'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    } elseif($data['pass'] !== $data['confi']){
        $status = [
            'status' => 'error',
            'message' => 'パスワードが一致していません'
        ];
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($status);
        exit;
    }


    // 正規表現
    // $email = 'hogehoge@email.com';

    // // バリデーションに使う正規表現
    // $pattern = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/";

    // if ( preg_match($pattern, $email ) ) {
    // echo "正しい形式のメールアドレスです。";
    // } else {
    // echo "不正な形式のメールアドレスです。";
    // }


    // filter_var関数
    // $email = 'hogehoge@email.com';

    // if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // echo "正しい形式のメールアドレスです。";
    // } else {
    // echo "不正な形式のメールアドレスです。";
    // }

    $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user ,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO signup (name, mail, pass) VALUES (:name, :mail, :pass)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam( ':name', $data['name'], PDO::PARAM_STR);
    $stmt->bindParam( ':mail', $data['mail'], PDO::PARAM_STR);
    $stmt->bindParam( ':pass', $data['pass'], PDO::PARAM_STR);  
    $stmt->execute();


    $stmt = $dbh->prepare("SELECT * FROM signup WHERE mail = :mail");
    $stmt->bindValue(':mail', $data['mail']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    $dbh = null;

}
catch (Exception $e)
{
    $status = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($status);
    exit;

    // echo $e->getMessage ();
    // echo 'ただいま障害により大変ご迷惑をお掛けしております。 ';
    // exit;
    
}
// セッションにユーザーネームを格納する
session_start();
$_SESSION['name'] = $result['name'];
$_SESSION['id'] = $result['id'];
// echo $_SESSION['name'];
// var_dump($_COOKIE["PHPSESSID"]);
// var_dump(session_id());
// var_dump($_SESSION['name']);

$status = [
    'status' => 'success',
    'user' => [
        'name' => $data['name'],
        'mail' => $data['mail']
    ],
    'message' => 'B成功'
];

header('Content-type: application/json; charset=utf-8');
echo json_encode($status);
exit;


?>