<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CoatRreservationRequest;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventUser;


class CoatReservationController extends Controller
{

    public function index(){
      return view('coat-reservation.index');
    }



    // public function reserve(){
    //   return view('coat-reservation.reserve');
    // }



    public function store(CoatRreservationRequest $request){

      // 同じ時間帯にイベント存在確認（Service使用）
      $check = EventService::checkEventDuplication($request['event_date'],$request['start_time'],$request['end_time']);

      // 存在したら
      if($check){
        session()->flash('status', 'この時間帯は既に他の予約が存在します。');
        // return to_route('coat-reservation.reserve');
        return to_route('coat-reservation.index');
      }


      // 日付と事項を合体
      $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
      $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

      // eventsテーブルに挿入
      $event =  Event::create([
        'name' => "コートレンタル_" . Auth::id() . "_" . Auth::user()->name . "_" .  $startDate,
        'kind' => 1,
        'user_id' => Auth::id(),
        'information' =>  "コートレンタル_" . Auth::id() . "_" . Auth::user()->name . "_" .  $startDate,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'max_people' => 0,
        'is_visible' => 1,
      ]);


      // event_userテーブルに挿入
      EventUser::create([
        'user_id' => Auth::id(),
        'event_id' => $event->id,
        'number_of_people' => 1,
      ]);


      session()->flash('status', 'コートレンタル予約okです');
      // return redirect()->route('mypage.events');
      return redirect()->route('mypage.index');

    }



    public function cancel(Event $event){

//後でトランザクション

      //▼event_user テーブル に canceled_date 挿入

      // start_dateカラムを取得したいのでevent_userテーブルに eventsテーブルを join
      $eventUserJoin = DB::table('event_user')
      ->join('events','event_user.event_id', '=', 'events.id')
      ->where('event_user.event_id',$event->id)
      ->where('event_user.user_id',Auth::id())
      ->select('event_user.*','start_date')
      ->orderBy('event_user.created_at','desc')
      ->first();


      // 本日以降のみキャンセル可能にする
      if( \Carbon\CarbonImmutable::parse($eventUserJoin->start_date)->format('Y-m-d H:i:s')  >  \Carbon\CarbonImmutable::today()->format('Y-m-d H:i:s')){

        EventUser::where('event_user.event_id',$event->id)
        ->where('event_user.user_id',Auth::id())
        ->latest()
        ->first()
        ->update([
          'canceled_date' => CarbonImmutable::now()->format('Y-m-d H:i:s'),
        ]);

        //events テーブル（canceled_date）
        Event::where('id',$event->id)
        ->where('user_id',Auth::id())
        ->latest()
        // ->first() 
        // を付けるとなぜかevents テーブルのみ不具合 canceled_date が入らない
        ->update([
          'canceled_date' => CarbonImmutable::now()->format('Y-m-d H:i:s'),
        ]);


        return redirect()->route('mypage.index')->with('status','コートレンタルをキャンセルしました。');
      }else{
        return redirect()->route('mypage.index')->with('status','過去のコートレンタルはキャンセル出来ません。');
      }

    }



}
