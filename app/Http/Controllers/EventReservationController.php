<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;

class EventReservationController extends Controller
{

  public function reserve(Event $event, Request $request){

// dd($event->is_visible);

    // 何かの不具合で非表示のイベントが飛んで来た場合、早期リターン
    // ここ厳密等価演算子はＮＧ
    if($event->is_visible == false){
      return back()->with(['status' =>'alert','message' =>'非表示中のイベントは予約出来ません。']);
    }


    // このイベントの予約人数
    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
    ->whereNull('canceled_date')
    ->groupBy('event_id')
    ->having('event_id', $event->id)
    ->first();


    // 自分が既に予約していないかの確認変数
    $ownReserveExists = DB::table('event_user')
    ->where('user_id','=',Auth::id())
    ->where('event_id','=',$event->id)
    ->whereNull('canceled_date')
    ->orderBy('created_at','desc')
    ->limit(1)
    ->exists();

    // 自分が既に予約していないかの確認
    if(!$ownReserveExists){
      // 当該イベントの予約が無いか、定員が（予約数+予約希望人数）以上であれば
      if( is_null($reservedPeople) || $request->max_people >= $reservedPeople->number_of_people + $request->number_of_people ){

        EventUser::create([
          'user_id' => Auth::id(),
          'event_id' => $event->id,
          'number_of_people' => $request->number_of_people,
        ]);

        return redirect()->route('mypage.index')->with(['status' =>'info','message' =>'イベント：　予約okです']);

      }else{
        return back()->with(['status' =>'alert','message' =>'イベント：　人数的に予約出来ませんでした。他の方が同時に予約した可能性もあります']);        
      }

    }else{
        return redirect()->route('mypage.index')->with(['status' =>'alert','message' =>'イベント：　既にご自分で予約済です。']);        

    }

  }



  public function cancel(Event $event){

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

      return redirect()->route('mypage.index')->with(['status' =>'info','message' =>'イベントをキャンセルしました。']);
    }else{
      return redirect()->route('mypage.index')->with(['status' =>'alert','message' =>'過去のイベントはキャンセル出来ません。']);
    }


  }




}
