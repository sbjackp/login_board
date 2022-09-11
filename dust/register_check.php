<?php

$name=$_POST['name'];
$mail=$_POST['mail'];
$pass=$_POST['pass'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像掲示板</title>
    <link rel="stylesheet" href="login_board.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="login">
        <h1 class="title">画像掲示板</h1>
        <h1 class="login_top">新規会員登録</h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h5 class="register mb-2">こちらで登録致します</h5>
                    <div>
                        <p></p>
                        <p></p>
                        <p></p>
                    </div>
                    <form method="post" action="register_done.php">
                        <input class="member mb-3" type="hidden" name="name" value="<?php echo $name ?>"><br>
                        <input class="member mb-3" type="hidden" name="mail" value="<?php echo $mail ?>"><br>
                        <input class="pass mb-3" type="hidden" name="pass" value="<?php echo $pass ?>"><br>
                        <button class="btn btn-warning mb-4">確認画面へ</button>
                    </form> 
                <form action="register.php">
                        <h5 class="already mb-2">会員登録済の方はこちら</h5>
                        <button class="btn btn-success mb-3">ログイン</button>
                        <h5 class="pass_lost mb-4">パスワードをお忘れの方はこちら＞</h5>
                </form>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>