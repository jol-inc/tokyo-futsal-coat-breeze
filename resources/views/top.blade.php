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
                    <p>～お客様～<br>
                    <p>▼コートレンタル<br>
                    <p>・カレンダーでコートの空き確認 → コートレンタルページから予約</p>
                    <p>▼店舗主催の各種イベントに参加</p>
                    <p>・カレンダーページで探して予約</p>
                    <p>▼マイページにて自身の予約状況を確認可能</p>
                  </div>

                  <div class="text-blue-500 mt-12 text-2xl">
                    <p>～店舗管理者～</p>
                    <p>▼店側で各種イベントを作成するとお客様が予約出来ます</p>
                    <p>・店舗管理者ページ　→　イベント新規登録ページ</p>
                    <p>▼店舗管理者ぺージにて店舗作成イベント、お客様コートレンタルの、一覧、詳細が確認可能</p>
                    <p>▼店舗管理者もお客様として予約出来る仕様です</p>
                  </div>

                  <div class="text-red-500 mt-12 text-2xl">
                    <p>～その他仕様～</p>
                    <p>▼ユーザー登録時のメール認証は便宜上省略</p>
                    <p>▼本日のイベントは時刻が過ぎた物も便宜上、編集、削除可能</p>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
