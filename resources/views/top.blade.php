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

                  <div class="text-2xl text-blue-500 mt-12">
                    <p>～お客様アカウントで出来る事～<br>
                    <p>▼コートレンタル<br>
                    <p>・カレンダーでコートの空き確認 → コートレンタルページから予約</p>
                    <p>▼店舗主催の各種イベントに参加</p>
                    <p>・カレンダーページで探して予約</p>
                    <p>▼マイページ</p>
                    <p>・自身の予約状況確認</p>
                    <p>・予約の取消</p>
                  </div>

                  <div class="text-2xl text-red-500 mt-8 mb-8">
                    <p>～店舗管理者アカウントで出来る事～</p>
                    <p>▼店側主催の各種イベントを作成</p>
                    <p>・店舗管理者ページ　→　イベント新規登録ページ</p>
                    <p>▼（店舗主催イベント、お客様コートレンタル）の一覧、詳細</p>
                    <p>▼便宜上、店舗管理者アカウントもお客様として使える仕様です</p>
                  </div>
                  

                  <div class="text-2xl">
                    <p>～その他仕様説明～</p>
                    <p>▼seederでのテストユーザー登録内訳<br>
                      ・お客様１： c1@c1.com パス pppppppp<br>
                      ・店舗マネージャー１： m1@m1.com パス pppppppp
                    </p>
                    <p>▼本日のイベントは時刻が過ぎていても、編集、削除可能</p>
                    <p>▼本来選択すべきでない過去のイベントも選択出来る様にしています。</p>
                    <p>▼フェイカーの設定上、ダミーイベントは時刻重複があります。</p>
                    <p>▼システム開発の見本の為、モバイル版はデザインしておりません。。</p>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
