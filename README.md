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




# SQLインジェクションについて

ログイン後、検索ページで 「xxx%' OR 1=1;」 と入力して検索すると、作成者が自分(tset@test.com)以外の人のメモも見れてしまいます。これがSQLインジェクションです。
検索フォームにSQL文を仕込んでおいて、予想とは異なる挙動をさせます。

実際のサービスでSQLインジェクションを試みると犯罪になりますので、絶対にやめてください。
