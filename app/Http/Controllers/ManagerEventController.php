<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;


class ManagerEventController extends Controller
{


  public function index(){

    $today = CarbonImmutable::today();

    // 予約人数の合計クエリ
    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people)
    as number_of_people'))
    ->whereNull('canceled_date') //キャンセルを除く
    ->groupBy('event_id');
    // サブクエリを外部結合で
    $events = DB::table('events')
    ->leftJoinSub($reservedPeople, 'reservedPeople',
    function($join){
    $join->on('events.id', '=', 'reservedPeople.event_id');
    })

    ->whereDate('start_date','>=',$today)
    ->orderBy('start_date','desc')
    ->paginate(10);

    return view('manager.events.index',compact('events'));
  }


  public function create()
  {
    return view("manager.events.create");
  }


  public function store(StoreEventRequest $request)
  {

    // 存在確認（サービス使用）
    $check = EventService::checkEventDuplication($request['event_date'],$request['start_time'],$request['end_time']);

    // 存在したら
    if($check){
      session()->flash('status', 'この時間帯は既に他の予約が存在します。');
      return view('manager.events.create');
    }

    // 日付と事項を合体
    $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
    $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

    Event::create([
      'name' => $request['event_name'],
      'kind' => 5,
      'user_id' => Auth::id(),
      'information' => $request['information'],
      'start_date' => $startDate,
      'end_date' => $endDate,
      'max_people' => $request['max_people'],
      'is_visible' => $request['is_visible'],
    ]);

    session()->flash('status', '登録okです');
    return redirect()->route('manager.events.index');
  }


  public function show(Event $event)
  {
      // $event = Event::findOrFail($event->id);これ上でDIしてるから不要だよね？
    
      $users = $event->users;

      $reservations = []; // 連想配列を作成
      foreach($users as $user)
      {
        $reservedInfo = [
        'name' => $user->name,
        'number_of_people' => $user->pivot->number_of_people,
        'canceled_date' => $user->pivot->canceled_date
        ];
        array_push($reservations, $reservedInfo); // 連想配列に追加
      }


      $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
      $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
      $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');

      // dd(Carbon::today()->format('Y年m月d日'));       

      return view('manager.events.show',compact('event','users','reservations','eventDate','startTime','endTime'));
  }


  public function edit(Event $event)
  {
    $users = $event->users;

    $reservations = []; // 連想配列を作成
    foreach($users as $user)
    {
      $reservedInfo = [
      'name' => $user->name,
      'number_of_people' => $user->pivot->number_of_people,
      'canceled_date' => $user->pivot->canceled_date
      ];
      array_push($reservations, $reservedInfo); // 連想配列に追加
    }


    $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
    $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
    $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');

    // dd(Carbon::today()->format('Y年m月d日'));       

    return view('manager.events.edit',compact('event','users','reservations','eventDate','startTime','endTime'));
  }


  public function update(StoreEventRequest $request, Event $event)
  {

    // 存在確認（サービス使用）
    $check = EventService::checkEventUpdateDuplication($request['event_date'],$request['start_time'],$request['end_time']);

    // 存在したら
    if($check > 1){
// session()->flash('status', 'この時間帯は既に他の予約が存在します。');
// return view('manager.events.create');
return back()->with('status', 'この時間帯は既に他の予約が存在します。');
    }

    // 日付と事項を合体
    $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
    $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);


    $event->name = $request['event_name'];
    $event->kind = 5;
    $event->user_id = Auth::id();
    $event->information = $request['information'];
    $event->start_date = $startDate;
    $event->end_date = $endDate;
    $event->max_people = $request['max_people'];
    $event->is_visible = $request['is_visible'];

    $event->save();


    session()->flash('status', '更新okです');
    return redirect()->route('manager.events.index');
  }


  public function past(){

    $today = CarbonImmutable::today();

    // 予約人数の合計クエリ
    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people)
    as number_of_people'))
    ->whereNull('canceled_date') //キャンセルを除く
    ->groupBy('event_id');
    // サブクエリを外部結合で
    $events = DB::table('events')
    ->leftJoinSub($reservedPeople, 'reservedPeople',
    function($join){
    $join->on('events.id', '=', 'reservedPeople.event_id');
    })

    ->whereDate('start_date','<',$today)
    ->orderBy('start_date','desc')
    ->paginate(10);

    return view('manager.events.past',compact('events'));
  }



}
