<?php
    //一ページに表示する記事の数をmax_viewに定数として定義
    define('max_view',3);

    error_log("ログの出力の確認");

    // $start = 1;
    // $max = 3;

    try{
        //test@localhostでblogに接続
        // $pdo = new PDO('mysql:dbname=blog;host=localhost;charset=utf8','test','パスワード');

        $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user ,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    } catch (PDOException $error) {
        //エラーの場合はエラーメッセージを吐き出す
        exit("データベースに接続できませんでした。<br>" . $error->getMessage());
    }

    $count = $dbh->prepare('SELECT COUNT(*) AS count FROM posts');
    $count->execute();
    $total_count = $count->fetch(PDO::FETCH_ASSOC);
    $pages = ceil($total_count['count'] / max_view);

    //必要なページ数を求める
    // $count = $pdo->prepare('SELECT COUNT(*) AS count FROM posts');
    // $count->execute();
    // $total_count = $count->fetch(PDO::FETCH_ASSOC);
    // $pages = ceil($total_count['count'] / max_view);


    var_dump($pages);

    //現在いるページのページ番号を取得
    if(!isset($_GET['page_id'])){ 
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }

    // var_dump($now);
    error_log(print_r($now,true));
    error_log(print_r(max_view,true));

//表示する記事を取得するSQLを準備
//     // $select = $pdo->prepare("SELECT title,file_path FROM posts ORDER BY no DESC LIMIT :start,:max ");

    $select = $dbh->prepare('SELECT signup.name as author,signup.created_at as signup_created_at,posts.title,posts.body,posts.created_at as posts_created_at,post_images.file_name FROM posts INNER JOIN signup ON posts.signup_id = signup.id LEFT JOIN post_images ON posts.id = post_images.post_id ORDER BY posts_created_at DESC LIMIT :start,:max');

    // $select = $dbh->query('SELECT signup.name as author,signup.created_at as signup_created_at,posts.title,posts.body,posts.created_at as posts_created_at,post_images.file_name FROM posts INNER JOIN signup ON posts.signup_id = signup.id LEFT JOIN post_images ON posts.id = post_images.post_id ORDER BY posts_created_at DESC');

    // $select->bindValue(":start",$start,PDO::PARAM_INT);
    // $select->bindValue(":max",$max,PDO::PARAM_INT);

                                                                                                           
    if ($now == 1){
        $select->bindValue(":start",$now -1,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    } else {

        $select->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    }

    $select->execute();
    $data = $select->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($data);
    echo json_encode($data);



?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ページネーション</title>
    </head>
    <body>
        <ul>
            <?php
                foreach ( $data as $row ) {
                    echo "<li>{$row[title]}{$row[author]}{$row[body]}{$row[title]}</li>";
                }
            ?>
        </ul>
        <?php
            for ( $n = 1; $n <= $pages; $n ++){
                if ( $n == $now ){
                    echo "<span style='padding: 5px;'>$now</span>";
                }else{
                    echo "<a href='./test.php?page_id=$n' style='padding: 5px;'>$n</a>";
                }
            }
        ?>
    </body>
</html>


