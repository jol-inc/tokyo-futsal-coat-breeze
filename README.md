### ダウンロード方法
git clone https://github.com/jol-inc/tokyo-futsal-coat-breeze
  
  
### インストール方法
cd jol-inc  
composer install  
npm install  
npm run dev  

▼.env  
.env.example をコピーして .envファイルを作成  
.envファイルの中の下記をご利用の環境に合わせて変更してください。  
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1   
DB_PORT=3306   
DB_DATABASE=xxxxxxxx  
DB_USERNAME=xxxxxxxx  
DB_PASSWORD=xxxxxxxx  


▼データベーステーブルとダミーデータの追加  
XAMPP/MAMPまたは他の開発環境でDBを起動した後に、  
php artisan migrate:fresh --seed  


▼php artisan key:generate でキーを生成。   

▼php artisan serve で簡易サーバーを立ち上げ、表示確認。  
