### ダウンロード方法
git clone https://github.com/jol-inc/tokyo-futsal-coat-breeze
  
  
### インストール方法
cd tokyo-futsal-coat-breeze  
composer install  
npm install  
npm run dev  
  

### 設定  
▼.env  
.env.example をコピーして .envファイルを作成  
.envファイルの中の下記をご利用の環境に合わせて変更してください。    

APP_ENV=  
APP_DEBUG=  
APP_URL=  

DB_CONNECTION=  
DB_HOST=  
DB_PORT=  
DB_DATABASE=  
DB_USERNAME=  
DB_PASSWORD=  


▼DB  
・phpmyadminでデータベース作成（db名、 user、 password 設定）

▼テーブルとダミーデータの追加  
・php artisan migrate:fresh --seed  

▼php artisan key:generate でキーを生成。   
  

### 表示確認  
▼php artisan serve で簡易サーバーを立ち上げ or 他のローカル環境。  
  

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー  
  
### メール送信設定  
▼.env  
MAIL_〇〇 の部分を 変更する。  
  

●ローカルは mailtrap を推奨。登録して値を取得。１  
　MAIL_MAILER=smtp
　MAIL_HOST=sandbox.smtp.mailtrap.io
　MAIL_PORT=2525
　MAIL_USERNAME=
　MAIL_PASSWORD=""  ※クオーテーションの有無でエラーになる事アリ。  
　MAIL_ENCRYPTION=tls  

　※以下は他のcinfigファイル or ここで設定。
　MAIL_FROM_ADDRESS=
　MAIL_FROM_NAME=
  
  
●リモートサーバーは以下を任意の値  

　MAIL_HOST=
　MAIL_PORT=
　MAIL_USERNAME=
　MAIL_PASSWORD=""  ※クオーテーションの有無でエラーになる事アリ。  
  

### アカウント登録時 メール認証機能（テスト環境では無くても良い）    
  
▼app/Models/Advertiser.phpを編集  

以下を追加  
use Illuminate\Contracts\Auth\MustVerifyEmail;  
use Illuminate\Foundation\Auth\User as Authenticatable;  
use Illuminate\Notifications\Notifiable;  
  
class Advertiser extends Authenticatable を以下に変更  
class Advertiser extends Authenticatable implements MustVerifyEmail  
{  
  
　use Notifiable;  を追加  
  
  
▼routes/web.php  
  
・メール認証をする物を'verified' で囲む  
Route::middleware('auth','verified',