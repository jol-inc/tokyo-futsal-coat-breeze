<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          イベントカレンダー
      </h2>
  </x-slot>



  @php
  define('EVENT_TIME',[
    // const EVENT_TIME = [
    '08:00:00',
    '08:30:00',
    '09:00:00',
    '09:30:00',
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
    '20:30:00',
    '21:00:00',
    '21:30:30',
    '22:00:00',
    '22:30:30',
    '23:00:00',
    // ];
      ]);
    define('CALENDAR_LEFT_TIME',[
    // const CALENDAR_LEFT_TIME = [
    '08:00',
    '08:30',
    '09:00',
    '09:30',
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
    '20:30',
    '21:00',
    '21:30',
    '22:00',
    '22:30',
    '23:00',
    // ];
    ]);
  @endphp



  <div class="py-12">
    <div class="event-calendar mx-auto sm:px-6 lg:px-8 flex">
      <div class="pt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mx-auto">



        <div class="flex justify-around">

          <div>
            <div class="text-left text-sm">
              日付を選択して下さい。本日から最大30日先まで選択可能です。
              <p class="text-blue-600">※テストの為、過去も選択可能</p> 
            </div> 
            <form id="calendar-change" action="{{route('events.calendar-change')}}" method="GET">
              <x-text-input type="text" name="calendar" id="calendar"  value="{{ $currentDate }}" class="block mt-4 w-48 border-indigo-200 border-8" />
            </form>
          </div>

          <div>
            <div class="py-1 px-2 h-8 border border-gray-500 text-xs ">空白はコートレンタル可能</div>  
            <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">予約可能イベント</div>  
            <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-green-100">自分で予約済</div>
            <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-red-100">満員</div>
          </div>

        </div>

        {{-- ここでFLEXを効かせている（以下横並び） --}}
        <div class="flex border border-green-400 mx-auto my-8">

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
              @for($j = 0; $j < 31; $j++)
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

                    <a href="{{ route('events.show',['event' => $eventId ]) }}">                       

                      {{-- 背景色関連のPHP --}}
                      @php
                        $event = \DB::table('events')->where('id',$eventId)->latest()->first();


                        // 自分が既に予約していないかの確認変数
                        $ownReserveExists = \DB::table('event_user')
                        ->where('user_id','=',\Auth::id())
                        ->where('event_id','=',$event->id)
                        ->whereNull('canceled_date')
                        ->orderBy('created_at','desc')
                        ->limit(1)
                        ->exists();


                        // Service 切り離し 予約可能人数
                        $reservablePeople = \App\Services\EventService::reservablePeopleFromCalendar($event,$eventId);
                      @endphp

                      {{-- 自分で予約済の時 --}}
                      @if($ownReserveExists)
                        <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-green-100">
                      {{-- 満員の時 --}}
                      @elseif($reservablePeople <= 0)
                        <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-red-100">
                      {{--それ以外の時 --}}
                      @else
                        <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">  
                      @endif
                        {{ $eventName }}
                      </div>
                    </a>

                    {{-- 背景色のみ --}}
                    {{-- 開始時刻、終了時刻の差を30分で割り 1を引いた数値が無くなる迄背景色付div --}}
                    @if( $eventPeriod > 0)
                      @for($k = 0; $k < $eventPeriod; $k++)
                        <a href="{{ route('events.show',['event' => $eventId ]) }}">

                        {{-- 自分で予約済の時 --}}
                        @if($ownReserveExists)
                          <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-green-100">
                        {{-- 満員の時 --}}
                        @elseif($reservablePeople <= 0)
                          <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-red-100">
                        {{--それ以外の時 --}}
                        @else
                          <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">  
                        @endif
                        </div>
                       </a>
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