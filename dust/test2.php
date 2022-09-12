<!-- セッションのnameに値があれば変数に代入 -->
<?php
    session_start();
    if(isset($_SESSION['name'])){
        $name = $_SESSION['name'];
        $id = $_SESSION['id'];
    }


    if(!isset($_GET['page_id'])){ 
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }

    echo $now;

    
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
    <link rel="stylesheet" href="../assets/css/login_board.css?v=2">
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
                    <li><a href="logout.php" class="logout">ログアウト</a></li>
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
                        <input type="hidden" class="now" value="<?php echo $now ?>">
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

            <div id="post_list"></div>

        </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="test.js" charset="utf-8">
    </script>
</body>
</html>