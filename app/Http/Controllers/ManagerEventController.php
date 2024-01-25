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

  // 本日以降のイベント一覧
  public function index(){

    $today = CarbonImmutable::today();

    // 予約人数の合計クエリ
    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
    ->whereNull('canceled_date') //通常イベントのキャンセルを除く （event_userテーブル）
    ->groupBy('event_id');


    // サブクエリを外部結合で
    $events = DB::table('events')
    ->leftJoinSub($reservedPeople, 'reservedPeople',
    function($join){$join->on('events.id', '=', 'reservedPeople.event_id');})
    ->whereNull('events.customer_canceled_date') //コートレンタルのキャンセルを除く （eventsテーブル）
    ->whereDate('start_date','>=',$today)
    ->orderBy('start_date','asc')
    ->paginate(10);

    return view('manager.events.index',compact('events'));
  }


  public function create()
  {
    return view("manager.events.create");
  }



  public function store(StoreEventRequest $request)
  {

    // 存在確認（Service使用）
    $check = EventService::checkEventDuplication($request['event_date'],$request['start_time'],$request['end_time']);

    // 存在したら
    if($check){
      return back()->with(['status' =>'alert','message' =>'この時間帯は既に他の予約が存在します。']);
    }

    // 日付と事項を合体
    $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
    $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);
    // 挿入
    Event::create([
      'name' => $request['event_name'],
      'kind' => config("own_const.EVENT_KIND.STORE_EVENT"),
      'user_id' => Auth::id(),
      'information' => $request['information'],
      'start_date' => $startDate,
      'end_date' => $endDate,
      'max_people' => $request['max_people'],
      'is_visible' => $request['is_visible'],
    ]);

    return redirect()->route('manager.events.index')->with(['status' =>'info','message' =>'イベント新規登録okです']);
  }

  

  public function show(Event $event)
  {
    $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
    $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
    $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');

    // ▼当該イベントとそれに紐づくuserを取得（イベント詳細の下に配置）
    $eventUsers = $event->users;

    return view('manager.events.show',compact('event','eventDate','startTime','endTime','eventUsers'));
  }



  public function edit(Event $event)
  {
    // ▼以下 show() とほぼ同じ
    $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
    $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
    $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');

    return view('manager.events.edit',compact('event','eventDate','startTime','endTime'));
  }



  public function update(StoreEventRequest $request, Event $event)
  {

    // 存在確認（Service使用）
    $check = EventService::checkEventDuplicationExceptOwn(


    // 自身のイベントidも渡す
    $event->id,
    $request['event_date'],$request['start_time'],$request['end_time']);


    // 既に予約が存在したら
    if ($check) {
      return back()->with(['status' =>'alert','message' =>'この時間帯は既に他の予約が存在します。']);
    }

    // 日付と事項を合体
    $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
    $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

    // 挿入
    $event->name = $request['event_name'];
    $event->kind = config("own_const.EVENT_KIND.STORE_EVENT");
    $event->user_id = Auth::id();
    $event->information = $request['information'];
    $event->start_date = $startDate;
    $event->end_date = $endDate;
    $event->max_people = $request['max_people'];
    $event->is_visible = $request['is_visible'];

    $event->save();


    // ▼以下 show() と同じ

    // ▼当該イベントとそれに紐づくuserを取得（イベント詳細の下に配置）
    $eventUsers = $event->users;

    $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
    $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
    $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');

    return redirect()->route('manager.events.show',compact('event','eventDate','startTime','endTime','eventUsers'))->with(['status' =>'info','message' =>'更新okです']);

  }



  public function past(){

    // ▼index() とほぼ同じ

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
    function($join){$join->on('events.id', '=', 'reservedPeople.event_id');})
    // ->whereNull('canceled_date')//コートレンタルのキャンセルを除く （eventsテーブル）
    ->whereNull('events.customer_canceled_date')//コートレンタルのキャンセルを除く （eventsテーブル）
    ->whereDate('start_date','<',$today)
    ->orderBy('start_date','desc')
    ->paginate(10);

    return view('manager.events.past',compact('events'));
  }



}
