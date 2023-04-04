<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        店舗管理者（イベント編集ページ）
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="max-w-2xl py-4 mx-auto">

            @if(session('status') === 'alert')
              <x-my.alert>
                {{ session('message') }}
              </x-my.alert>
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



              {{-- <form method="POST" action="{{ route('manager.events.update',['event' => $event->id]) }}">
                @csrf
                @method('put')
                <div>
                    <x-input-label for="event_name" value="イベント名" />
                    <x-text-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value=" {{ $event->name }} " required />
                </div>

                <div>
                    <x-input-label for="information" value="イベント詳細" />
                    <textarea name="information" id="information" rows="3" class="block mt-1 w-full" required>{{ $event->information }}</textarea>
                </div>

                <div class="md:flex justify-between">
                  <div class="mt-4">
                    <x-input-label for="event_date" value="イベント日付" />
                    <x-text-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{ $eventDate }}" required />
                  </div>
                  <div class="mt-4">
                    <x-input-label for="start_time" value="開始時間" />
                    <x-text-input id="start_time" class="block mt-1 w-full" type="text" name="start_time"  value="{{ $startTime }}" required />
                  </div>
                  <div class="mt-4">
                    <x-input-label for="end_time" value="終了時間" />
                    <x-text-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{ $endTime }}" required />
                  </div>
                </div>
                
                <div class="md:flex justify-between items-end">
                  <div class="mt-4">
                    <x-input-label for="max_people" value="定員数" />
                    <x-text-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" value="{{ $event->max_people }}" required />
                  </div>
                  <div class="space-x-4 justify-around">
                    <x-input-label for="is_visible" value="イベントカレンダー等に表示or非表示" />
                    <input type="radio" name="is_visible" value="1" @if($event->is_visible === 1) checked @endif>表示
                    <input type="radio" name="is_visible" value="0" @if($event->is_visible === 0) checked @endif>非表示
                  </div>
                  <x-primary-button class="ml-3">
                    編集実行する
                  </x-primary-button>
                </div>

              </form>



 <br><br><br><br><br><br><br> --}}


              <form method="POST" action="{{ route('manager.events.update',['event' => $event->id]) }}">
                @csrf
                @method('put')
              {{-- <form method="GET" action="{{ route('manager.events.edit',['event' => $event->id]) }}"> --}}
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_name" value="イベントID" /></th>
                      <td class="px-4 py-3">{{ $event->id }}</td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_name" value="イベント名" /></th>
                      <td class="px-4 py-3"><x-text-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value=" {{ $event->name }} " required /></td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="information" value="イベント詳細" /></th>
                      <td class="px-4 py-3">
                        <textarea name="information" id="information" rows="3" class="block mt-1 w-full" required>{{ $event->information }}</textarea>
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="event_date" value="イベント日付" /></th>
                      <td class="px-4 py-3">
                        <x-text-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{ $eventDate }}" required />
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="start_time" value="開始時間" /></th>
                      <td class="px-4 py-3">
                        <x-text-input id="start_time" class="block mt-1 w-full" type="text" name="start_time"  value="{{ $startTime }}" required />
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="end_time" value="終了時間" /></th>
                      <td class="px-4 py-3"> 
                        <x-text-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{ $endTime }}" required />
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="max_people" value="定員数" /></th>
                      <td class="px-4 py-3">
                        <x-text-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" value="{{ $event->max_people }}" required />
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"><x-input-label for="is_visible" value="イベントカレンダー等に表示or非表示" /></th>
                      <td class="px-4 py-3">
                        <div>
                          @if($event->is_visible)
                          表示中
                          @else
                            非表示中
                          @endif
                        </div>                    
                        <input type="radio" name="is_visible" value="1" @if($event->is_visible === 1) checked @endif>表示
                        <input type="radio" name="is_visible" value="0" @if($event->is_visible === 0) checked @endif>非表示
                      </td>
                    </tr>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                      <td class="px-4 py-3">
                        {{-- 本日以降なら表示 --}}
                        @if( $eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                          <x-primary-button class="ml-3">
                            編集実行する
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
</x-app-layout>




<script>
const setting = {
  locale: "ja",
  enableTime: true,
  noCalendar: true,
  dateFormat: "H:i",
  time_24hr: true,
  minTime: "08:00",
  maxTime: "23:00",
}

flatpickr("#event_date", {
  locale: "ja",
  // minDate: "today",
  maxDate: new Date().fp_incr(30)
});

flatpickr("#start_time", setting);

flatpickr("#end_time", setting);
</script>
