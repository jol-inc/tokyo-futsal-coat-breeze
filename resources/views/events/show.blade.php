<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @auth
          マイページ（イベント詳細）
        @endauth
        @guest
          （イベント詳細）
        @endguest
      </h2>
  </x-slot>


  
  <div class="pt-4 pb-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-2xl py-4 mx-auto">


              {{-- //アラート 通常表示される事はないがバグを考慮して念の為 --}}
              @if(session('status') === 'alert')
              <x-my.alert>
                {{ session('message') }}
              </x-my.alert>
              @endif



              @if ($errors->any())
              <div class="text-red-500">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif


                <div>
                    <x-input-label for="event_name" value="イベントＩＤ" />
                    {{ $event->id }}
                </div>
                <div class="mt-2">
                    <x-input-label for="event_name" value="イベント名" />
                    {{ $event->name }}
                </div>

                <div class="mt-2">
                    <x-input-label for="information" value="イベント詳細" />
                    {!! nl2br(e($event->information)) !!}
                </div>

                <div class="md:flex justify-between">
                  <div class="mt-4">
                    <x-input-label for="event_date" value="イベント日付" />
                    {{ $eventDate }}
                  </div>
                  <div class="mt-4">
                    <x-input-label for="start_time" value="開始時間" />
                    {{ $startTime }}
                  </div>
                  <div class="mt-4">
                    <x-input-label for="end_time" value="終了時間" />
                    {{ $endTime }}
                  </div>
                </div>
             

                <div class="md:flex justify-between items-end">

                  <div class="mt-4">
                    <x-input-label for="max_people" value="定員数" />
                    {{ $event->max_people }}
                  </div>
                  {{-- 自分が予約していない場合 --}}
                  @if(!$ownReserveExists)
                  
                    <form method="POST" id="eventReserve_{{ $event->id }}" action="{{ route('event-reservation.reserve',$event->id) }}">
                      @csrf 

                      @if($reservablePeople <= 0 )
                        <span class="text-red-500 text-xs">このイベントは満員です。</span>
                      @else
                        <select name="number_of_people" id="">
                          @for ($i=1; $i <= $reservablePeople; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>

                        <a href="#" data-id="{{ $event->id }}" onclick=" return eventReserve(this)" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0 focus:outline-none hover:bg-gray-600 rounded">予約する</a>
                      @endif
                    </form>

                  @else
                    {{-- 現在以降の場合 --}}
                    @if( \Carbon\CarbonImmutable::parse($event->start_date)->format('Y-m-d H:i:s')  >   \Carbon\CarbonImmutable::today()->format('Y-m-d H:i:s')  )

                      <p class="text-green-600">既にご自分で予約済です。</p>

                      @if ( $event->kind == config("own_const.EVENT_KIND.STORE_EVENT") )

                        {{-- イベント用 キャンセル --}}
                        <form method="POST" id="eventCancel_{{ $event->id }}" action="{{ route('event-reservation.cancel',$event->id) }}">
                          @csrf
                          <a href="#" data-id="{{ $event->id }}" onclick=" return eventCancel(this)" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0 focus:outline-none hover:bg-gray-600 rounded">キャンセルする</a>
                        </form>

                      @elseif( $event->kind == config("own_const.EVENT_KIND.COAT_RENTAL") )

                        {{-- コートレンタル用 キャンセル--}}
                        <form method="POST" id="coatCancel_{{ $event->id }}" action="{{ route('coat-reservation.cancel',$event->id) }}">
                          @csrf
                          <a href="#" data-id="{{ $event->id }}" onclick=" return coatCancel(this)" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0 focus:outline-none hover:bg-gray-600 rounded">キャンセルする</a>
                        </form>

                      @endif


                    @endif
                  @endif

                </div>

            </div>
          </div>
      </div>
  </div>



  <script>

    // イベント予約
    function eventReserve(e){
      "use strict";
      if ( confirm('本当に予約しますか？') ){
        document.getElementById( "eventReserve_" + e.dataset.id ).submit();
      }
    }

    // イベント用 キャンセル
    function eventCancel(e){
      "use strict";
      if ( confirm('本当にキャンセルしますか？') ){
        document.getElementById( "eventCancel_" + e.dataset.id ).submit();
      }
    }

    // コートレンタル用 キャンセル
    function coatCancel(e){
      "use strict";
      if ( confirm('本当にキャンセルしますか？') ){
        document.getElementById( "coatCancel_" + e.dataset.id ).submit();
      }
    }

  </script>


</x-app-layout>