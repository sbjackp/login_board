<!-- セッションのnameに値があれば変数に代入 -->
<?php
    session_start();
    if(isset($_SESSION['name'])){
        $name = $_SESSION['name'];
        $id = $_SESSION['id'];
    }

    
    require_once './db/data_base.php';
    require_once './utility/function.php';

    //一ページに表示する記事の数をmax_viewに定数として定義
    define('max_view',3);

    error_log("ログの出力の確認");

    // $start = 1;
    // $max = 3;

    $dbh = db();

    $count = $dbh->prepare('SELECT COUNT(*) AS count FROM posts');
    $count->execute();
    $total_count = $count->fetch(PDO::FETCH_ASSOC);
    $pages = ceil($total_count['count'] / max_view);

    //必要なページ数を求める
    // $count = $pdo->prepare('SELECT COUNT(*) AS count FROM posts');
    // $count->execute();
    // $total_count = $count->fetch(PDO::FETCH_ASSOC);
    // $pages = ceil($total_count['count'] / max_view);


    // var_dump($pages);

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



    // var_dump($now);



?>

    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像掲示板</title>
    <link rel="stylesheet" href="./assets/css/sanitize.css">
    <link rel="stylesheet" href="./assets/css/top.css">
    <link rel="stylesheet" href="./assets/css/login_board.css?v=2">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="header">
            <a href="/">
                <div>画像掲示板</div>
            </a>

            <ul class="link_items">
                <?php if (isset($name)) : ?>
                    <li><?php echo $name ?></li>
                    <li><a href="/logout" class="logout">ログアウト</a></li>
                <?php else : ?>
                    <li><a href="/login">ログイン</a></li>
                    <li><a href="/signup">新規登録</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="write">
            <?php if (isset($name)) : ?>
                
                <h2>投稿はこちら</h2>
                <div class="error"></div>
                <form method="post" enctype="multipart/form-data">
                        <input type="hidden" class="user" value="<?php echo $name ?>">
                        <input type="hidden" class="id" value="<?php echo $id ?>">
                        <div class="form-group mb-1">
                            <input type="text" class="form-control name" name="title" placeholder="タイトル">
                        </div>
                        <div class="form-group mb-1">
                            <textarea class="form-control message" name="body" rows="5" placeholder="メッセージ"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="image">
                            <label class="input-group-text" for="image">Upload</label>
                        </div>
                        <input type="submit" class="btn btn-success send btn-block" name="btn_submit" value="書き込む">
                </form>
            <?php endif; ?>

            <!-- <div id="post_list"></div> -->

            <ul>
                <?php foreach ( $data as $row ) : ?>
                    <?php if(!isset($row[file_name])) : ?>
                        <div class="lists">
                            <div class="list_title"><?php echo h($row[title]) ?></div>
                            <div class="list_author"><?php echo h($row[author]) ?></div>
                            <div><?php echo h($row[posts_created_at]) ?></div>
                            <div class="list_body return"><?php echo h($row[body]) ?></div>
                        </div>
                    <?php else : ?>
                        <div class="lists">
                            <div class="list_title"><?php echo h($row[title]) ?></div>
                            <div class="list_author"><?php echo h($row[author]) ?></div>
                            <div><?php echo h($row[posts_created_at]) ?></div>
                            <div class="list_body return"><?php echo h($row[body]) ?></div>
                            <img class="post_image" src="/images/<?php echo h($row[file_name]) ?>">
                        </div>
                    <?php endif ; ?>
                <?php endforeach; ?>


            </ul>
            <?php
                for ( $n = 1; $n <= $pages; $n ++){
                    if ( $n == $now ){
                        echo "<span style='padding: 5px;'>$now</span>";
                    }else{
                        echo "<a href='./.?page_id=$n' style='padding: 5px;'>$n</a>";
                    }
                }
            ?>

        </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="post.js" charset="utf-8">
    </script>
</body>
</html>