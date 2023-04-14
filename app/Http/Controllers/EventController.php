<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Services\EventService;


class EventController extends Controller
{

    public $currentDate;
    public $currentWeek;
    public $day;

    public $checkDay;
    public $dayOfWeek;
    public $sevenDaysLater;

    public $events;


    public function calendar(){

      //リクエスト日（今日）の変数
      //ココはcalendarChange()と違う（今日である）
      $this->currentDate = CarbonImmutable::today();

      //リクエスト週（今週）の変数の配列化
      $this->currentWeek = [];

      // $this->currentWeekに挿入してゆく
      //ココはcalendarChange()と違う（ココは今日が基準の1週間）
      for($i = 0; $i < 7; $i++):
        $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
        $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
        $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
        array_push( $this->currentWeek, [
          'day' => $this->day,
          'checkDay' => $this->checkDay,
          'dayOfWeek' => $this->dayOfWeek,
        ]);
      endfor;


      $this->events = EventService::getWeekEvents(
        CarbonImmutable::today()->format('Y-m-d'),
        CarbonImmutable::today()->addDays(7)->format('Y-m-d'),
      );


      $currentDate = $this->currentDate;
      $currentWeek = $this->currentWeek;
      $events      = $this->events;

      return view('events.calendar',compact('currentDate','currentWeek','events'));
      
    }



    public function calendarChange(Request $request){

      //リクエスト日の情報を作成
      //ココは calendar() と違う（リクエスト日） 
      $this->currentDate = CarbonImmutable::parse($request->calendar);

      //リクエスト週（今週）の変数の配列化
      $this->currentWeek = [];
  
      // $this->currentWeekに挿入してゆく
      //ココは calendar() と違う（こっちはリクエスト日が基準）
      for($i = 0; $i < 7; $i++){
        $this->day = CarbonImmutable::parse($request->calendar)->addDays($i)->format('m月d日');
        $this->checkDay = CarbonImmutable::parse($request->calendar)->addDays($i)->format('Y-m-d');
        $this->dayOfWeek = CarbonImmutable::parse($request->calendar)->addDays($i)->dayName;
        array_push( $this->currentWeek, [
          'day' => $this->day,
          'checkDay' => $this->checkDay,
          'dayOfWeek' => $this->dayOfWeek,
        ]);
      }
  

      $this->events = EventService::getWeekEvents(
        CarbonImmutable::parse($request->calendar)->format('Y-m-d'),
        CarbonImmutable::parse($request->calendar)->addDays(7)->format('Y-m-d'),
      );


      $currentDate = $this->currentDate;
      $currentWeek = $this->currentWeek;
      $events      = $this->events;

  
      return view('events.calendar',compact('currentDate','currentWeek','events'));
    }



    public function show(Event $event){


      // 何かの不具合で非表示のイベントが飛んで来た場合、早期リターン
      // ここ厳密等価演算子はＮＧ
      if($event->is_visible == false){
        abort(404);
      }


      // ▼変数色々
      $eventDate = CarbonImmutable::parse($event->start_date)->format('Y年m月d日');
      $startTime = CarbonImmutable::parse($event->start_date)->format('H時i分');
      $endTime   = CarbonImmutable::parse($event->end_date)->format('H時i分');
  

      // ▼予約可能人数  （定員 ー 予約済人数）※キャンセル除く
      $reservedPeople = DB::table('event_user')
      ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
      ->whereNull('canceled_date')
      ->groupBy('event_id')
      ->having('event_id', $event->id )
      ->first();

      if(!is_null($reservedPeople)){ 
        $reservablePeople = $event->max_people - $reservedPeople->number_of_people; 
      }else { 
        $reservablePeople = $event->max_people;
      } 


      // ▼自分が既に予約していないかの確認変数
      $ownReserveExists = DB::table('event_user')
      ->where('user_id','=',Auth::id())
      ->where('event_id','=',$event->id)
      ->whereNull('canceled_date')
      ->orderBy('created_at','desc')
      ->limit(1)
      ->exists();


      return view('events.show',compact('event','eventDate','startTime','endTime','reservablePeople','ownReserveExists'));

    }

    
}
