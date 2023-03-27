<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          イベント詳細
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


              {{-- <form method="GET" action="{{ route('events.edit',['event' => $event->id]) }}"> --}}
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

                  <div class="flex space-x-4 justify-around">
                    @if($event->is_visible)
                      表示中
                    @else
                      非表示中
                    @endif
                  </div>

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
            @if (!$users->isEmpty())
              <div class="text-center py-2">予約状況</div>
              <table class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                  <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">予約者名</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reservations as $reservation)
                    @if(is_null($reservation['canceled_date']))
                      <tr>
                        <td class="px-4 py-3">{{ $reservation['name'] }}</td>
                        <td class="px-4 py-3">{{ $reservation['number_of_people']}}</td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>

        </div>
    </div>
  </div>


</x-app-layout>
