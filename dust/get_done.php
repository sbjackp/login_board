<?php



try {
    $dsn = 'mysql:dbname=login_board;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user ,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->query('SELECT signup.name as author,signup.created_at as signup_created_at,posts.title,posts.body,posts.created_at as posts_created_at,post_images.file_name FROM posts INNER JOIN signup ON posts.signup_id = signup.id LEFT JOIN post_images ON posts.id = post_images.post_id ORDER BY posts_created_at DESC');
    // $stmt = $dbh->query('SELECT signup.name as author,signup.created_at as signup_created_at,posts.title,posts.body,posts.created_at as posts_created_at FROM posts INNER JOIN signup ON posts.signup_id = signup.id ORDER BY posts_created_at DESC');
    $res = $stmt->execute();
    $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // error_log ('内容');
    // error_log ('$lists: ' . print_r ($lists, true));
    // var_dump($lists);
    echo json_encode($lists);
    // echo json_encode('テスト');
    

    $dbh = null;
} catch (Exception $e) {
        echo $e->getMessage ();

        // 更新書き込みを防ぐ
        // echo 'ただいま障害により大変ご迷惑をお掛けしております。 ';
        exit();
}



?>