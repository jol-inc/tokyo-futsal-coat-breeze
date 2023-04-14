<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;


class EventService
{

  public static function checkEventDuplication($eventDate,$startTime,$endTime){
    return DB::table('events')
    ->whereDate('start_date', $eventDate) // 日にち
    ->whereTime('end_date','>',$startTime)
    ->whereTime('start_date','<', $endTime)
    // ->whereNull('canceled_date')//コートレンタルキャンセル
->whereNull('customer_canceled_date')//コートレンタルキャンセル
    ->exists(); 
  }



  public static function checkEventDuplicationExceptOwn($ownEventId, $eventDate, $startTime, $endTime)
  {
    $event = DB::table('events')
      ->whereDate('start_date', $eventDate)
      ->whereTime('end_date', '>', $startTime)
      ->whereTime('start_date', '<', $endTime)
      // ->whereNull('canceled_date')//コートレンタルキャンセル
  ->whereNull('customer_canceled_date')//コートレンタルキャンセル
      ->get()
      ->toArray();
    
    // そもそも日付が重複していない
    if (empty($event)) {
      return false;
    }
    
    // 重複があったイベントのidを取得
    $eventId = $event[0]->id;
    
    // 重複していたイベントが自身の場合、重なっていないと判定
    if ($ownEventId === $eventId) {
      return false;
    } else {
      return true;
    }
  }



  public static function joinDateAndTime($date,$time){
    $join = $date . " " . $time;
    return CarbonImmutable::createFromFormat('Y-m-d H:i', $join);
  }



  public static function reservablePeopleFromCalendar($event,$eventId){


    // ▼予約可能人数  （定員 ー 予約済人数）※キャンセル除く
    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
    ->whereNull('canceled_date')
    ->groupBy('event_id')
    ->having('event_id', $eventId )
    ->first();

    if(!is_null($reservedPeople)){ 
      $reservablePeople = $event->max_people - $reservedPeople->number_of_people; 
    }else { 
      $reservablePeople = $event->max_people;
    } 

    return $reservablePeople;
  }


  public static function getWeekEvents($startDate, $endDate)
  {

      //リクエスト週のイベント情報を取得（外部結合でnullも含め、イベント毎に何人予約あるかも把握）
  
      //$reservedPeopleは下部$events作成の為の変数
      $reservedPeople = DB::table('event_user')
      ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
      ->groupBy('event_id');
  
      //外部結合の理由は、イベントに予約が有っても無くてもイベント自体が作成されているのか知りたい為
      return DB::table('events')
      ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
      $join->on('events.id', '=', 'reservedPeople.event_id');
      })
      ->where('is_visible',true)//表示中にした物
      ->whereNull('events.customer_canceled_date')//コートレンタルをキャンセルした物は非表示
      ->whereBetween('start_date', [$startDate, $endDate])
      ->orderBy('start_date', 'asc')
      ->get();

  }



}
