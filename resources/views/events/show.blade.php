<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          マイページ（イベント詳細）
      </h2>
  </x-slot>

  <div class="pt-4 pb-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-2xl py-4 mx-auto">

              @if(session('status'))
              <div class="mb-4 font-medium text-sm text-green-700">
                {{ session('status') }}
              </div>
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
                <div>
                    <x-input-label for="event_name" value="イベント名" />
                    {{ $event->name }}
                </div>

                <div>
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
                  {{-- 自分が既に予約していないかの確認 --}}
                  @if(!$ownReserveExists)
                    {{-- <form method="POST" action="{{ route('event-reservation.reserve',['id' => $event->id]) }}"> --}}
                    <form method="POST" id="reservation_{{ $event->id }}" action="{{ route('event-reservation.reserve',['id' => $event->id]) }}">

                      @csrf 

                      @if($reservablePeople <= 0 )
                        <span class="text-red-500 text-xs">このイベントは満員です。</span>
                      @else
                        <select name="number_of_people" id="">
                          @for ($i=1; $i <= $reservablePeople; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>

                        <x-primary-button  data-id="{{ $event->id }}" onclick="reservationPost(this)" class="ml-3">
                          予約する
                        </x-primary-button>
                      @endif
                    </form>
                  @else
                    {{-- 本日以降の場合 --}}
                    @if( \Carbon\CarbonImmutable::parse($event->start_date)->format('Y-m-d H:i:s')  >   \Carbon\CarbonImmutable::today()->format('Y-m-d H:i:s')  )

                      <p class="text-green-600">既にご自分で予約済です。</p>


                      @if ( $event->kind === 1 )
                      {{-- コートレンタル用 --}}
                        <form method="POST" id="coatCancel_{{ $event->id }}" action="{{ route('coat-reservation.cancel',['id' => $event->id]) }}">
                          @csrf
                          <x-primary-button  data-id="{{ $event->id }}" onclick=" return coatCancel(this)" class="ml-3">
                            キャンセルする
                          </x-primary-button>
                        </form>
                      @else
                      {{-- イベント用 --}}
                        <form method="POST" id="eventCancel_{{ $event->id }}" action="{{ route('event-reservation.cancel',['id' => $event->id]) }}">
                          @csrf
                          <x-primary-button  data-id="{{ $event->id }}" onclick=" return eventCancel(this)" class="ml-3">
                            キャンセルする
                          </x-primary-button>
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
    function reservationPost(e){
      "use strict";
      if ( confirm('本当に予約しますか？') ){
        document.getElementById( "reserve_" + e.dataset.id ).submit();
      }
    }


    function coatCancel(e){
      "use strict";
      if ( confirm('本当にキャンセルしますか？') ){
        document.getElementById( "coatCancel_" + e.dataset.id ).submit();
      }
    }


    function eventCancel(e){
      "use strict";
      if ( confirm('本当にキャンセルしますか？') ){
        document.getElementById( "eventCancel_" + e.dataset.id ).submit();
      }
    }



  </script>


</x-app-layout>