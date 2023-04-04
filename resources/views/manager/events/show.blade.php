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
{{-- @if(session('status') === 'info')
<div id="alert-border-3" class="w-2/3 mx-auto flex p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
  <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
  <div class="ml-3 text-sm font-medium">
    {{ session('message') }}
  </div>
</div>
@endif
@if(session('status') === 'alert')
  <div id="alert-border-2" class="flex p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div class="ml-3 text-sm font-medium">
      {{ session('message') }}
    </div>
  </div>
@endif --}}


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

                  <div class="space-x-4 justify-around">
                    <x-input-label for="is_visible" value="イベントカレンダー等に表示or非表示" />
                    @if($event->is_visible)
                      表示中
                    @else
                      非表示中
                    @endif
                  </div>

                  {{-- 本日以降なら表示 --}}
                    {{-- @if( $eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                      <x-primary-button class="ml-3">
                        編集ページへ
                      </x-primary-button>
                    @endif
                    
                </div>
              </form> --}}



            <form method="GET" action="{{ route('manager.events.edit',['event' => $event->id]) }}">
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
                      @if( $eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                      <x-primary-button class="ml-3">
                        編集ページへ
                      </x-primary-button>
                      @endif
                    </td>
                  </tr>
              </table>
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
