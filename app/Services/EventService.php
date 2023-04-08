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






}
