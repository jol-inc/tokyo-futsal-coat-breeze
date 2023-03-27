<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          編集ページ
      </h2>
  </x-slot>

  <div class="py-12">
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

              <form method="POST" action="{{ route('manager.events.update',['event' => $event->id]) }}">
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
                  <div class="flex space-x-4 justify-around">
                    <input type="radio" name="is_visible" value="1" @if($event->is_visible === 1) checked @endif>表示
                    <input type="radio" name="is_visible" value="0" @if($event->is_visible === 0) checked @endif>非表示
                  </div>
                  <x-primary-button class="ml-3">
                    編集実行する
                  </x-primary-button>
                </div>

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
  minTime: "10:00",
  maxTime: "20:00",
}

flatpickr("#event_date", {
  locale: "ja",
  // minDate: "today",
  maxDate: new Date().fp_incr(30)
});

flatpickr("#start_time", setting);

flatpickr("#end_time", setting);
</script>
