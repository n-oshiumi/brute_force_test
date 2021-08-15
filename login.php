<?php
//セッションを使うことを宣言
session_start();

//データベースに接続する
require('./database.php');

$message = "";
//postされて来た場合
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    // メールアドレス・パスワードが送られてこなかった場合
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //検索したメールアドレスに対してパスワードが正しいかを確認
        if (!$result || (!password_verify($_POST['password'], $result['password']))) {
            $message = "メールアドレスもしくはパスワードが異なります";
        } else {
            session_regenerate_id(TRUE); //セッションidを再発行
            $_SESSION["login"] = $_POST['email']; //セッションにログイン情報を登録
            header("Location: index.php"); //ログイン後のページにリダイレクト
            exit();
        }
    }
}


$message = htmlspecialchars($message);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブルートフォース攻撃用サイト</title>
    <link rel="stylesheet" href="./css/destyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-default bg-info">
        <div class="container-fluid justify-content-center">
            <div class="navbar-header">
                <div class="navbar-brand text-white">ブルートフォース攻撃用ログインフォーム</div>
            </div>
        </div>
        </nav>
    </header>
    <div class="body-wrapper p-5">
        <h1>ログインページ</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">メールアドレス</label>
                <input type="email" class="form-control w-25" id="exampleInputEmail1" name="email" placeholder="メールアドレスを入力してください">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">パスワード</label>
                <input type="password" class="form-control w-25" id="exampleInputPassword1" name="password" placeholder="パスワードを入力してください">
            </div>
            <button type="submit" class="btn btn-primary">ログイン</button>
        </form>
        <div class="text-danger mt-5" style="font-size: 14px"><?= $message; ?></div>
    </div>
</body>
</html>
