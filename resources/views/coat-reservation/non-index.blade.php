<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        コートレンタル（ＴＯＰ）
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
                  <div class="flex justify-center last:first-letter: p-6 text-gray-900">
                    <button onclick="location.href='{{ route('coat-reservation.reserev') }}'" class="mx-4 py-2 px-6 text-white bg-indigo-500 border-0 focus:outline-none hover:bg-indigo-600 rounded">コートレンタル予約ページへ</button>
                  </div>
                  <ul>
                    <li>料金（1時間）</li>
                    <li>平日 ￥10000</li>
                    <li>休日 ￥15000</li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
