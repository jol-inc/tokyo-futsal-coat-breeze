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
    ->whereNull('canceled_date')//コートレンタルキャンセル
    ->exists(); 
  }


  public static function checkEventUpdateDuplication($eventDate,$startTime,$endTime){
    return DB::table('events')
    ->whereDate('start_date', $eventDate) // 日にち
    ->whereTime('end_date','>',$startTime)
    ->whereTime('start_date','<', $endTime)
    ->whereNull('canceled_date')//コートレンタルキャンセル
    ->count(); 
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
    // ->having('event_id', $event->id )
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
