<?php

error_log("ログの出力の確認");
error_log(print_r($_FILES['image'], true));

$data = $_POST;
// var_dump($data);
// // var_dump($_POST['title']);
// exit;

$errors = [];
$image_flag = false;


// ランダム関数
function random($length = 8)
{
    return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
}

// error_log(var_dump($_FILES));

// if(isset($_POST)) {
//     var_dump($_POST);
// }

if(mb_strlen($data['title']) === 0){
    
    $errors['title'] = "Bタイトルを入力して下さい";
    // $status = [
    //     'status' => 'error',
    //     'message' => 'Bタイトルを入力して下さい'
    // ];
    // header('Content-type: application/json; charset=utf-8');
    // echo json_encode($status);
    // exit;
}

if(mb_strlen($data['body']) === 0){

    $errors['body'] = "Bメッセージを入力して下さい";

    // $status = [
    //     'status' => 'error',
    //     'message' => 'Bメッセージを入力して下さい'
    // ];
    // header('Content-type: application/json; charset=utf-8');
    // echo json_encode($status);
    // exit;
}

if(count($errors) !== 0) {
    // var_dump($errors);
    $response = [
      "status" => "error",
      "errors" => $errors
    ];
    header('Content-type: application/json; charset=utf-8');
      echo json_encode($response);
      exit;
}



if(isset($_FILES['image'])) {
    $image_flag = true;
    list($img_width, $img_height, $mime_type, $attr) = getimagesize($_FILES['image']['tmp_name']);
    //list関数の第3引数にはgetimagesize関数で取得した画像のMIMEタイプが格納されているので条件分岐で拡張子を決定する
    // var_dump($mime_type);
    // var_dump(IMAGETYPE_PNG);
    // var_dump(IMAGETYPE_JPEG);
    // var_dump(IMAGETYPE_GIF);
    switch($mime_type){
        //jpegの場合
        case IMAGETYPE_JPEG:
            //拡張子の設定
            $img_extension = "jpg";
            break;
        //pngの場合
        case IMAGETYPE_PNG:
        //拡張子の設定
            $img_extension = "png";
            break;
        //gifの場合
        case IMAGETYPE_GIF:
            //拡張子の設定
            $img_extension = "gif";
            break;
        
        default:
            $errors['image_format'] = "アップロードできるファイル形式はjpg,png,gifのみです。";
            
    }
    //拡張子の出力
    // echo $img_extension;
   
    // $size = filesize($_FILES['image']['tmp_name']);
    // var_dump($size);

    // バリデーションが上手く行かない
    if(!isset($_FILES['image']['size']) &&
    !is_numeric($_FILES['image']['size']) &&
    $_FILES['image']['size'] > 1100) {
        $errors['image_size'] = "アップロードできるファイルは1MBまでです";
    }

    // if($size > 1100000) {
    //     $errors['image_size'] = "アップロードできるファイルは1MBです";
    // }

    if(count($errors) !== 0) {
        // var_dump($errors);
        $response = [
          "status" => "error",
          "errors" => $errors
        ];
        header('Content-type: application/json; charset=utf-8');
          echo json_encode($response);
          exit;
    }

    $now = time();
    // var_dump($now);

    $text = random(12);
    // var_dump($text);
    
    $file_name = $now.$text.'.'.$img_extension;
    // var_dump($file_name);

    

    if(!move_uploaded_file( $_FILES['image']['tmp_name'], '../images/'.$file_name)) {
        // 投稿に失敗しました
        // exit;
    }


}





// header("Content-type: application/json; charset=UTF-8");
// JSONデータを出力
// echo json_encode($_POST);
// echo json_encode($_FILES);
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
    
    


    $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user ,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO posts (signup_id, title, body) VALUES (:signup_id, :title, :body)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam( ':signup_id', $data['id'], PDO::PARAM_STR);
    $stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR);
    $stmt->bindParam( ':body', $data['body'], PDO::PARAM_STR);
    $stmt->execute();


    if(isset($_FILES['image'])) {
        $stmt2 = $dbh->query('SELECT id FROM posts ORDER BY id DESC LIMIT 1');
        $res = $stmt2->execute();
        $lists = $stmt2->fetch();
        // $lists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $sql = 'INSERT INTO post_images (post_id, file_name) VALUES (:id, :name)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam( ':id', $lists['id'], PDO::PARAM_STR);
        $stmt->bindParam( ':name', $file_name, PDO::PARAM_STR);
        // $stmt->bindParam( ':id', $data['id'], PDO::PARAM_STR);
        // $stmt->bindParam( ':name', $lists['id'], PDO::PARAM_STR);
        $stmt->execute();
    }
    
    $dbh = null;


    // $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
    // $user = 'root';
    // $password = 'root';
    // $dbh = new PDO($dsn, $user ,$password);
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

    

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
// session_start();
// $_SESSION['name'] = $result['name'];
// $_SESSION['id'] = $result['id'];

// echo $_SESSION['name'];
// var_dump($_COOKIE["PHPSESSID"]);
// var_dump(session_id());
// var_dump($_SESSION['name']);

$status = [
    'status' => 'success',
    'message' => 'B成功'
];

header('Content-type: application/json; charset=utf-8');
echo json_encode($status);
// echo ($status);
// var_dump($status);
exit;


?>