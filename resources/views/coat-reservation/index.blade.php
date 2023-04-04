<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        コートレンタル
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
  <div id="alert-border-3" class="flex w-2/3 mx-auto p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div class="ml-3 text-sm font-medium">
      {{ session('message') }}
    </div>
  </div>
@endif
@if(session('status') === 'alert')
  <div id="alert-border-3" class="flex w-2/3 mx-auto p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
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

              <p class="my-8">予約後にカレンダー、マイページ等でご確認下さい。</p>

              <form method="POST" id="coatRreservation" action="{{ route('coat-reservation.store') }}">
                @csrf

                <div class="md:flex justify-between">
                  <div class="mt-4">
                    <x-input-label for="event_date" value="日付" />
                    <x-text-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" required />
                  </div>
                  <div class="mt-4">
                    <x-input-label for="start_time" value="開始時間" />
                    <x-text-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" required />
                  </div>
                  <div class="mt-4">
                    <x-input-label for="end_time" value="終了時間" />
                    <x-text-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" required />
                  </div>
                </div>
                
                <div class="md:flex justify-center mt-4">
                  <a href="#" onclick="coatReservation()" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0 focus:outline-none hover:bg-gray-600 rounded">予約する</a>
                </div>

              </form>
            </div>
          </div>
      </div>
  </div>
</x-app-layout>




<script>
flatpickr("#event_date", {
  locale: "ja",
  // minDate: "today",
  maxDate: new Date().fp_incr(30)
});

const setting = {
  locale: "ja",
  enableTime: true,
  noCalendar: true,
  dateFormat: "H:i",
  time_24hr: true,
  minTime: "08:00",
  maxTime: "23:00",
  minuteIncrement: 30
}

flatpickr("#start_time", setting);
flatpickr("#end_time", setting);
</script>

<script>
  function coatReservation(){
    "use strict";
    if ( confirm('本当に予約しますか？') ){
      document.getElementById( "coatRreservation" ).submit();
    }
  }
</script>
