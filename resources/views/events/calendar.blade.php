<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          イベントカレンダー
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="event-calendar mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


        @php
        define('EVENT_TIME',[
          // const EVENT_TIME = [
          '10:00:00',
          '10:30:00',
          '11:00:00',
          '11:30:00',
          '12:00:00',
          '12:30:00',
          '13:00:00',
          '13:30:00',
          '14:00:00',
          '14:30:00',
          '15:00:00',
          '15:30:00',
          '16:00:00',
          '16:30:00',
          '17:00:00',
          '17:30:00',
          '18:00:00',
          '18:30:00',
          '19:00:00',
          '19:30:00',
          '20:00:00',
          // ];
            ]);
          define('CALENDAR_LEFT_TIME',[
          // const CALENDAR_LEFT_TIME = [
          '10:00',
          '10:30',
          '11:00',
          '11:30',
          '12:00',
          '12:30',
          '13:00',
          '13:30',
          '14:00',
          '14:30',
          '15:00',
          '15:30',
          '16:00',
          '16:30',
          '17:00',
          '17:30',
          '18:00',
          '18:30',
          '19:00',
          '19:30',
          '20:00',
          // ];
          ]);
        @endphp


        <div class="text-left text-sm">
          日付を選択して下さい。本日から最大30日先まで選択可能です。
          <p class="text-red-400">※便宜上、現状はいつでも選択可能</p> 
        </div> 

        {{-- <form id="calendar-change" action="{{route('calendar.change')}}" method="POST"> --}}
          @csrf
          <x-text-input id="calendar" class="block mt-4 w-48 border-indigo-700 border-8" type="text" name="calendar" />
        </form>

        <p class="mx-4 my-4">本日： {{ $currentDate }}</p>

        {{-- ここでFLEXを効かせている（以下横並び） --}}
        <div class="flex border border-green-400 mx-auto">

          {{-- ここでFLEXの塊 --}}
          {{-- 最左列（表説明、時間軸表示）--}}
          <div class="w-32">
            <div class="py-1 px-2 border border-gray-200 text-center">日</div>
            <div class="py-1 px-2 border border-gray-200 text-center">曜日</div>
            @foreach ( CALENDAR_LEFT_TIME as $clt)
              <div class="py-1 px-2 h-8 border border-gray-200">{{ $clt }}</div>
            @endforeach
          </div>


          {{-- ここも１列毎にFLEX塊 --}}
          {{-- 2列目以降（日付及び実データ部分） --}}
          @for ($i = 0; $i < 7; $i++)
            <div class="w-32">
              <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div>
              <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
              @for($j = 0; $j < 21; $j++)
                @if($events->isNotEmpty()){{-- イベントが1週間無かった場合はelseで全部div作成--}}
                  {{-- このdivにイベントが無い場合はelseでdiv作成--}}
                  @if( !is_null($events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " . EVENT_TIME[$j]) )  )
                    @php

                      // 詳細ページに飛ぶ為のid
                      $eventId = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " . EVENT_TIME[$j])->id;
                      // div内に記入するイベント名
                      $eventName = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " . EVENT_TIME[$j])->name;
                      // イベントオブジェクト
                      $eventInfo = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " . EVENT_TIME[$j]);
                      // 開始時刻、終了時刻の差を30分で割り 1を引いた数値   
                      $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)->diffInMinutes($eventInfo->end_date) / 30 - 1;
                    @endphp
                    {{-- イベント名、 背景色 --}}

{{-- <a href="{{ route('events.show',['id' => $eventId ]) }}"> --}}
{{-- <a href="{{ route('events.show',['event' => $eventId ]) }}"> --}}
<a href="{{ route('events.show',['event' => $eventId ]) }}">
          <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">
            {{ $eventName }}
          </div>
        </a>
                    {{-- 背景色のみ --}}
                    {{-- 開始時刻、終了時刻の差を30分で割り 1を引いた数値が無くなる迄背景色付div --}}
                    @if( $eventPeriod > 0)
                      @for($k = 0; $k < $eventPeriod; $k++)
        {{-- <a href="{{ route('events.show',['id' => $eventId ]) }}"> --}}
          <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-100"></div>
        {{-- </a> --}}
                      @endfor
                      {{-- 背景色付divを数個作ってしまったので、残りの空白divの数を修正--}}
                      @php $j += $eventPeriod @endphp
                    @endif
                  @else
                    <div class="py-1 px-2 h-8 border border-gray-200"></div>
                  @endif
                @else
                  <div class="py-1 px-2 h-8 border border-gray-200"></div>
                @endif

              @endfor
            </div>
          @endfor


        </div>


    

        <script>// フラットピッカー用
          flatpickr("#calendar", {
            locale: "ja",
  // minDate: "today",
            maxDate: new Date().fp_incr(30)
          });
        </script>


        <script>// 日付送信用
          var calendar = document.getElementById('calendar');

          calendar.addEventListener('change', function() {
            document.getElementById("calendar-change").submit();
          })
        </script>
        

      </div>
    </div>
  </div>
</x-app-layout>