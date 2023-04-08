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
