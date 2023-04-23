<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            TOPページ
        </h2>
    </x-slot>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                  <div class="text-2xl">
                    <p>～お客様アカウントで出来る事～<br>
                    <p>▼コートレンタル<br>
                    <p>・カレンダーでコートの空き確認 → コートレンタルページから予約</p>
                    <p>▼店舗主催の各種イベントに参加</p>
                    <p>・カレンダーページで探して予約</p>
                    <p>▼マイページ</p>
                    <p>・自身の予約状況確認</p>
                    <p>・予約の取消</p>
                  </div>

                  <div class="text-blue-500 mt-12 text-2xl">
                    <p>～店舗管理者アカウントで出来る事～</p>
                    <p>▼店側主催の各種イベントを作成</p>
                    <p>・店舗管理者ページ　→　イベント新規登録ページ</p>
                    <p>▼店舗主催イベント、お客様コートレンタルの、一覧、詳細が確認可能</p>
                    <p>▼便宜上、店舗管理者アカウントでもお客様として予約出来る仕様です</p>
                  </div>

                  <div class="text-red-500 mt-12 text-2xl">
                    <p>～テスト仕様説明～</p>
                    <p>▼ユーザー登録時のメール認証は省略</p>
                    <p>▼本日のイベントは時刻が過ぎていても、編集、削除可能</p>
                    <p>▼フェイカーの設定上、ダミーイベントは時刻が重複があります。</p>
                    <p>▼システム開発の見本の為、モバイル版はデザインしておりません。。</p>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
