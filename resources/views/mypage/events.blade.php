 <x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        マイページ（予約済イベント）
      </h2>
  </x-slot>

  <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">


                  <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">

                      @if(session('status'))
                        <div class="mb-4 font-medium text-sm text-green-700">
                          {{ session('status') }}
                        </div>
                      @endif
                      

                      <h3 class="py-4 font-medium text-gray-900 text-lg">現在以降</h3> 
                      <div class="w-full mb-8 mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベントＩＤ</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント種別</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント名</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($from_today_events as $event)
                              <tr>
                                <td class="px-4 py-3">{{ $event->id }}</td>
                                <td class="px-4 py-3">{{\App\Services\MagicWordService::kind($event->kind)}}</td>
                                <td class="text-blue-500 px-4 py-3">
                                  <a href="{{ route('events.show',['event' => $event->id]) }}">{{ $event->name }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $event->start_date }}</td>
                                <td class="px-4 py-3">{{ $event->end_date }}</td>
                                <td class="px-4 py-3">
                                  @if(is_null($event->number_of_people))
                                    0
                                  @else
                                    {{ $event->number_of_people }}
                                  @endif
                                </td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
{{-- {{ $events->links() }} --}}
                      </div>

                      <h3 class="py-4 font-medium text-gray-900 text-lg">過去</h3> 
                      <div class="w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベントＩＤ</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント種別</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント名</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($past_events as $event)
                              <tr>
                                <td class="px-4 py-3">{{ $event->id }}</td>
                                <td class="px-4 py-3">{{\App\Services\MagicWordService::kind($event->kind)}}</td>

                                <td class="text-blue-500 px-4 py-3">
                                  <a href="{{ route('events.show',['event' => $event->id]) }}">{{ $event->name }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $event->start_date }}</td>
                                <td class="px-4 py-3">{{ $event->end_date }}</td>
                                <td class="px-4 py-3">
                                  @if(is_null($event->number_of_people))
                                    0
                                  @else
                                    {{ $event->number_of_people }}
                                  @endif
                                </td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
{{-- {{ $events->links() }} --}}
                      </div>

                    </div>
                  </section>


              </div>
          </div>
      </div>
  </div>
</x-app-layout>
