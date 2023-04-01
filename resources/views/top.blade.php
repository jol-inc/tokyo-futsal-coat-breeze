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
                  @if(session('status'))
                  <div class="mb-4 font-medium text-sm text-green-700">
                    {{ session('status') }}
                  </div>
                  @endif
                  <div class="text-2xl">
                    <p>～お客様～<br>
                    <p>▼コートレンタル<br>
                    <p>・カレンダーでコートの空き確認 → コートレンタルページから予約</p>
                    <p>▼店舗主催のイベントに参加（大会、スクール、 etc・・・）</p>
                    <p>・カレンダーページで探して予約</p>
                    <p>▼マイページにて自身の予約状況を確認出来ます</p>
                  </div>

                  <div class="text-red-500 mt-12 text-2xl">
                    <p>～店舗管理者～</p>
                    <p>▼各種イベントを店側で作成するとお客様が予約出来ます。</p>
                    <p>・店舗管理者　→　イベント新規登録ページ</p>
                    <p>▼便宜上、店舗管理者もお客様として予約出来る仕様です。</p>
                    <p>▼店舗管理者ぺージにてイベント、コートレンタルの一覧、詳細が確認出来ます。</p>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
