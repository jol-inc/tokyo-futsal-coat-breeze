<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;


class EventController extends Controller
{

    public function calendar(){

      //今日の情報を作成
      //ココはcalendarChange()と違う（今日である）
      $currentDate = CarbonImmutable::today()->format('m月d日');   

      //今週の情報を作成
      $currentWeek = [];

      //ココはcalendarChange()と違う（ココは今日が基準の1週間）
      for($i = 0; $i < 7; $i++):
        $day = CarbonImmutable::today()->addDays($i)->format('m月d日');
        $checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
        $dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
        array_push( $currentWeek, [
          'day' => $day,
          'checkDay' => $checkDay,
          'dayOfWeek' => $dayOfWeek,
        ]);
      endfor;


      ///////////////////////////////
      //今週のイベント情報を取得（外部結合でnullも含め、イベント毎に何人予約あるかも把握）

      //SQL whereBetweenに入れる変数       
      //ココはcalendarChange()と違う（今日が基準） 
      $startDate = CarbonImmutable::today()->format('Y-m-d');
      $endDate   = CarbonImmutable::today()->addDays(7)->format('Y-m-d');

      //$reservedPeopleは下部$events作成の為の変数
      $reservedPeople = DB::table('event_user')
      ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
      ->groupBy('event_id');

      //外部結合の理由は、イベントに予約が有っても無くてもイベント自体が作成されているのか知りたい為
      $events = DB::table('events')
      ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
      $join->on('events.id', '=', 'reservedPeople.event_id');
      })
      ->where('events.is_visible',true)//表示中のイベント
      ->whereBetween('start_date', [$startDate, $endDate])
      ->orderBy('start_date', 'asc')
      ->get();


      return view('events.calendar',compact('currentDate','currentWeek','events'));
      
    }



    public function calendarChange(Request $request){

      //リクエスト日の情報を作成
      //ココは calendar() と違う（リクエスト日） 
      $currentDate = CarbonImmutable::parse($request->calendar)->format('m月d日');
  
      
      //リクエスト週の情報を作成
      $currentWeek = [];
  
      //ココは calendar() と違う（こっちはリクエスト日が基準）
      for($i = 0; $i < 7; $i++){
        $day = CarbonImmutable::parse($request->calendar)->addDays($i)->format('m月d日');
        $checkDay = CarbonImmutable::parse($request->calendar)->addDays($i)->format('Y-m-d');
        $dayOfWeek = CarbonImmutable::parse($request->calendar)->addDays($i)->dayName;
        array_push( $currentWeek, [
          'day' => $day,
          'checkDay' => $checkDay,
          'dayOfWeek' => $dayOfWeek,
        ]);
      }
  
  
      //■■■■■ここから
      //リクエスト週のイベント情報を取得（外部結合でnullも含め、イベント毎に何人予約あるかも把握）
  
      //SQL whereBetweenに入れる変数       
      //ココはindex()と違う（リクエスト日が基準なので） 
      $startDate = CarbonImmutable::parse($request->calendar)->format('Y-m-d');
      $endDate   = CarbonImmutable::parse($request->calendar)->addDays(7)->format('Y-m-d');
  
      //$reservedPeopleは下部$events作成の為の変数
      $reservedPeople = DB::table('event_user')
      ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
      ->groupBy('event_id');
  
      //外部結合の理由は、イベントに予約が有っても無くてもイベント自体が作成されているのか知りたい為
      $events = DB::table('events')
      ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
      $join->on('events.id', '=', 'reservedPeople.event_id');
      })
      ->where('is_visible',true)//表示中にした物
      ->whereBetween('start_date', [$startDate, $endDate])
      ->orderBy('start_date', 'asc')
      ->get();
      // ここまで■■■■■
  
      return view('events.calendar',compact('currentDate','currentWeek','events'));
    }



    public function show(Event $event){

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
