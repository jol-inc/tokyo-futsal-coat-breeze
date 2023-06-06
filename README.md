### ダウンロード方法
git clone https://github.com/jol-inc/tokyo-futsal-coat-breeze
  
  
### インストール方法
cd tokyo-futsal-coat-breeze  
composer install  
npm install  
npm run dev  

▼.env  
.env.example をコピーして .envファイルを作成  
.envファイルの中の下記をご利用の環境に合わせて変更してください。  
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE= 
DB_USERNAME=
DB_PASSWORD=

APP_ENV=
APP_DEBUG=
APP_URL=

▼DB
・phpmyadminでデータベース作成（DB名 user password 設定）

▼テーブルとダミーデータの追加  
・php artisan migrate:fresh --seed  

▼php artisan key:generate でキーを生成。   

▼php artisan serve で簡易サーバーを立ち上げ、表示確認。  
