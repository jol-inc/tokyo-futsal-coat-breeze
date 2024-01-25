              <div class="flex justify-center last:first-letter: p-6 text-gray-900">

                @if ( !Request::routeIs('manager.events.index') )
                  <button onclick="location.href='{{ route('manager.events.index') }}'" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0focus:outline-none hover:bg-gray-600 rounded">本日以降のイベント一覧へ</button>
                @endif

                @if ( !Request::routeIs('manager.events.past') )
                  <button onclick="location.href='{{ route('manager.events.past') }}'" class="mx-4 py-2 px-6 text-white bg-gray-500 border-0 focus:outline-none hover:bg-gray-600 rounded">過去のイベント一覧へ</button>
                @endif

                @if ( !Request::routeIs('manager.events.create') )
                  <button onclick="location.href='{{ route('manager.events.create') }}'" class="mx-4 py-2 px-6 text-white bg-indigo-500 border-0 focus:outline-none hover:bg-indigo-600 rounded">イベント新規登録ページへ</button>
                @endif

              </div>
