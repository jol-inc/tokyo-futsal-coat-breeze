<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        店舗管理者（本日以降のイベント）
      </h2>
  </x-slot>

  <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">


                  <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">

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

                      @include('parts.manager-events-buttons')
                      <div class="w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベントＩＤ</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント種別</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-48">イベント名</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">イベントカレンダー等<br>に表示or非表示</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($events as $event)
                              <tr>
                                <td class="px-4 py-3">{{ $event->id }}</td>
                                <td class="px-4 py-3">{{\App\Services\MagicWordService::kind($event->kind)}}</td>
                                <td class="px-4 py-3 text-blue-500 w-48"><a href="{{ route('manager.events.show',['event' => $event->id]) }}">{{ $event->name }}</a></td>
                                <td class="px-4 py-3">{{ \Carbon\CarbonImmutable::parse("$event->start_date")->format('Y-m-d H:i'); }}</td>
                                <td class="px-4 py-3">{{ \Carbon\CarbonImmutable::parse("$event->end_date")->format('Y-m-d H:i'); }}</td>
                                <td class="px-4 py-3">
                                  @if(is_null($event->number_of_people))
 {{-- @if(is_null($event->pivot->number_of_people)) --}}

                                    0
                                  @else
                                    {{ $event->number_of_people }}
{{-- {{ $event->pivot->number_of_people }} --}}
                                  @endif
                                </td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                                <td class="px-4 py-3">
                                  @if($event->is_visible)
                                    表示中
                                  @else
                                    非表示中
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>

                        {{ $events->links() }}

                      </div>

                    </div>
                  </section>


              </div>
          </div>
      </div>
  </div>
</x-app-layout>
