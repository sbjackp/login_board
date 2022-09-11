

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="../assets/css/sanitize.css">
    <link rel="stylesheet" href="../assets/css/top.css">
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
                <li><a href="/login">ログイン</a></li>
                <li><a href="/signup">新規登録</a></li>
            </ul>
        </nav>
    </header>

    <div class="login">
        <h1 class="title">画像掲示板</h1>
        <h1 class="login_top">ログイン</h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                <div class="error_m">
                    <?php
                        session_start();
                        if(isset($_SESSION['error'])){
                            echo $_SESSION['error'];
                            $_SESSION = array();
                            session_destroy();
                        }
                    ?>
                </div>
                <div class="error"></div>
                <form method="post" action="login_check.php">                       
                        <input class="mail mb-3" type="text" name="mail" placeholder="会員ID（メールアドレス）"><br>
                        <div class="input-wrap">
                            <input class="pass1 mb-3" type="password" name="pass" placeholder="パスワード">
                            <i class="toggle-pass fa fa-eye-slash"></i><br>
                        </div>
                        <button class="btn_login btn-success mb-3">ログイン</button>
                        <h5 class="pass_lost mb-4">パスワードをお忘れの方はこちら＞</h5>
                </form> 
                    <form action="register.php">
                            <h5 class="already mb-2">会員登録済の方はこちら</h5>
                            <button class="btn_sign btn-warning mb-4">確認画面へ</button>
                    </form>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </script>
</body>
</html>