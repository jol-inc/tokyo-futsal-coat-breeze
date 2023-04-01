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
                    <p>コートレンタル： 1時間から予約可能（カレンダーで空の確認後、ご予約下さい）</p>
                    <p>イベント　　： フットサルスクール、 大会 etc・・・。 （全て個人単位でお申込み下さい）</p>
                  </div>

                  <ul class="text-red-500 mt-12 text-lg">
                    <li>※便宜上、店舗管理者もお客様として予約出来る仕様です。</li>
                  </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
