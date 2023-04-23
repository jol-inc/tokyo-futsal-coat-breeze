<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          店舗管理者（イベント詳細）
      </h2>
  </x-slot>

  <div class="pt-4 pb-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-2xl py-4 mx-auto">

              @if(session('status') === 'info')
                <x-my.info>
                  {{ session('message') }}
                </x-my.info>
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



            {{-- <form method="GET" action="{{ route('manager.events.edit',['event' => $event->id]) }}">
              <table class="table-auto w-full text-left whitespace-no-wrap">
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_id" value="イベントID" /></th>
                    <td class="px-4 py-3">{{ $event->id }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_name" value="イベント名" /></th>
                    <td class="px-4 py-3">{{ $event->name }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="information" value="イベント詳細" /></th>
                    <td class="px-4 py-3">{!! nl2br(e($event->information)) !!}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_date" value="イベント日付" /></th>
                    <td class="px-4 py-3">{{ $eventDate }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="start_time" value="開始時間" /></th>
                    <td class="px-4 py-3"> {{ $startTime }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="end_time" value="終了時間" /></th>
                    <td class="px-4 py-3"> {{ $endTime }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="max_people" value="定員数" /></th>
                    <td class="px-4 py-3">{{ $event->max_people }}</td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="is_visible" value="イベントカレンダー等に表示or非表示" /></th>
                    <td class="px-4 py-3">                    
                      @if($event->is_visible)
                        表示中
                      @else
                        非表示中
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                    <td class="px-4 py-3">
                      {{-- 本日以降なら表示 --}}
                      {{-- @if( $eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                      <x-primary-button class="ml-3">
                        編集ページへ
                      </x-primary-button>
                      @endif
                    </td>
                  </tr>
              </table>
            </form>

            <br><br><br><br> --}}


            {{-- <form method="POST" action="{{ route('manager.events.store') }}"> --}}
            <form method="GET" action="{{ route('manager.events.edit',['event' => $event->id]) }}">
              <div class="md:flex justify-evenly">
                <div>
                    <x-input-label for="event_id" value="イベントID" />
                    {{ $event->id }}
                </div>
                <div>
                    <x-input-label for="event_name" value="イベント名" />
                    {{-- <x-text-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" :value="old('event_name')" required /> --}}
                    {{-- <x-text-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value="{{ $event->name }}" /> --}}
                    {{ $event->name }}
                </div>
              </div>

              <div class="mt-2">
                  <x-input-label for="information" value="イベント詳細" />
                  {{-- <textarea name="information" id="information" rows="3" class="block mt-1 w-full" required>{{ old('information') }}</textarea> --}}
                  {{-- <textarea name="information" id="information" rows="3" class="block mt-1 w-full">{!! nl2br(e($event->information)) !!}</textarea> --}}
                  {!! nl2br(e($event->information)) !!}
              </div>

              <div class="md:flex justify-between">
                <div class="mt-4">
                  <x-input-label for="event_date" value="イベント日付" />
                  {{-- <x-text-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{ $eventDate }}"/> --}}
                  {{ $eventDate }}
                </div>
                <div class="mt-4">
                  <x-input-label for="start_time" value="開始時間" />
                  {{-- <x-text-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" value="{{ $startTime }}" /> --}}
                  {{ $startTime }}
                </div>
                <div class="mt-4">
                  <x-input-label for="end_time" value="終了時間" />
                  {{-- <x-text-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{ $endTime }}" /> --}}
                  {{ $endTime }}
                </div>
              </div>
              
              <div class="md:flex justify-between items-end">
                <div class="mt-4">
                  <x-input-label for="max_people" value="定員数" />
                  {{-- <x-text-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" required /> --}}
                  {{ $event->max_people }}
                </div>
                <div class="space-x-4 justify-around">
                  <x-input-label for="is_visible" value="イベントカレンダー等に表示or非表示" />
                  {{-- <input type="radio" name="is_visible" value="1" checked>表示
                  <input type="radio" name="is_visible" value="0">非表示 --}}
                  @if($event->is_visible)
                    表示中
                  @else
                    非表示中
                  @endif
                </div>
                {{-- <x-primary-button class="ml-3">
                  新規登録
                </x-primary-button> --}}
                {{-- 本日以降なら表示 --}}
                @if( $eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                <x-primary-button class="ml-3">
                  編集ページへ
                </x-primary-button>
                @endif
              </div>

            </form>


          </div>

        </div>
    </div>
</div>




  <div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="max-w-2xl py-4 mx-auto">
              <div class="text-center py-2 text-2xl">このイベントの予約状況</div>
              <table class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">予約者名</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- 予約者が空でなければ --}}
                  @if (!$eventUsers->isEmpty())
                    @foreach($eventUsers as $eventUser)
                      {{-- キャンセルされてなければ --}}
                      @if(is_null( $eventUser->pivot->canceled_date ))
                        <tr>
                          <td class="px-4 py-3">{{ $eventUser->name }}</td>
                          <td class="px-4 py-3">{{ $eventUser->pivot->number_of_people }}</td>
                        </tr>
                      @endif
                    @endforeach
                  @endif
                </tbody>
              </table>
          </div>

        </div>
    </div>
  </div>


</x-app-layout>
