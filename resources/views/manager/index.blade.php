<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          マネージャー（ＴＯＰ）
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class=" p-6 text-gray-900">
                <button onclick="location.href='{{ route('manager.events.index') }}'" class="mx-auto flex mb-4 ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">マネージャー本日以降のイベント一覧</button>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
