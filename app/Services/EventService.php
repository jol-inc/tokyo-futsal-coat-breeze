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


}
