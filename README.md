## 環境
今回は xampp を想定ですのでdockerの方は各所変更お願いします。
<br><br><br>



## ダウンロード方法
git clone https://github.com/jol-inc/tokyo-futsal-coat-breeze
<br><br><br>



## 各種インストール
cd tokyo-futsal-coat-breeze  
composer install  
npm install  
npm run dev  

MIXとBreeze が混在して
アイコンが特大になってしまう時  
resources/views/layouts/gust.blade.php
@vite(['resources/css/app.css', 'resources/js/app.js'])
の部分を消してコメントアウトの部分に変える。

<br><br><br>



## 設定ファイル  
▼.env  
.env.example をコピーして .envファイルを作成  
.envファイルの中をご利用の環境に合わせて変更。  
（xampp はそのまま、docker は変更）
<br><br><br>



## DB
▼DB作成  
・phpmyadminでデータベース作成（db名、 user、 password は .env を参照）

▼テーブルとダミーデータの追加  
php artisan migrate:fresh --seed  

▼APP_KEYキー生成   
php artisan key:generate
<br><br><br>



## 表示確認  
▼php artisan serve で簡易サーバーを立ち上げ or 他のローカル環境。  
<br><br><br>



## アカウント登録時の メール認証機能（テスト環境では無くても良い）    
  
▼ .envファイル編集
※メール認証はテスト環境として mailtrap に登録してアカウント情報を.envに記載する。

MAIL_MAILER=smtp  
MAIL_HOST=sandbox.smtp.mailtrap.io  
MAIL_PORT=2525  
MAIL_USERNAME=必須  
MAIL_PASSWORD=必須  ※ここはクオーテーションの有無でエラーになる事アリ。    
MAIL_ENCRYPTION=tls  
※以下は ここで設定してもよいし、他のcinfigファイルで設定しても良い。  
MAIL_FROM_ADDRESS=何でも良いが必須  
MAIL_FROM_NAME=必須   
<br><br>


▼app/Models/User.php  
※ファイル内の説明通り編集  
※一応このファイルのみメール認証切替出来ます。

▼routes/web.php  
※ファイル内の説明通り編集