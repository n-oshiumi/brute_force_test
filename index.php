<?php
session_start();
try {
    // ログイン状態かどうか確認
    if (!isset($_SESSION["login"])) {
        session_regenerate_id(TRUE);
        header("Location: login.php");
        exit();
    }

    // データベースと接続
    require_once('./database.php');

    // 認証ユーザーを取得する
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->bindValue(":email", $_SESSION["login"], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $result["id"];

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ブルートフォース攻撃用サイト</title>
    <link rel="stylesheet" href="./css/destyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-default bg-info">
        <div class="container-fluid justify-content-center">
            <div class="navbar-header">
                <div class="navbar-brand text-white">ブルートフォース攻撃用サイト</div>
            </div>
        </div>
        </nav>
    </header>
    <div class="body-wrapper p-5">
       ログイン成功！
    </div>
</body>
</html>
