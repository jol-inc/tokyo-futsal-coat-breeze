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

  public function reserve($id, Request $request){

    $reservedPeople = DB::table('event_user')
    ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
    ->whereNull('canceled_date')
    ->groupBy('event_id')
    ->having('event_id', $id)
    ->having('event_id', $id)
    ->first();

    // 自分が既に予約していないかの確認変数
    $ownReserveExists = DB::table('event_user')
    ->where('user_id','=',Auth::id())
    ->where('event_id','=',$id)
    ->whereNull('canceled_date')
    ->orderBy('created_at','desc')
    ->limit(1)
    ->exists();

    // 自分が既に予約していないかの確認
    if(!$ownReserveExists){
      // 当該イベントの予約が無いか、定員が（予約数+予約希望人数）以上であれば
      if( is_null($reservedPeople) || $request->max_people >= $reservedPeople->number_of_people + $request->number_of_people ){
        // dd("予約可能です。");
        DB::table('event_user')->insert([
          'user_id' => Auth::id(),
          'event_id' => $id,
          'number_of_people' => $request->number_of_people,
          'created_at' => CarbonImmutable::now(),
        ]);

        session()->flash('status', '登録okです');
        return redirect()->route('mypage.index');
      }else{
        session()->flash('status', '人数的に予約出来ませんでした。他の方が同時に予約した可能性もあります');
        // return view('top'); 
        return redirect()->route('mypage.index');
      }
    }else{
        session()->flash('status', '既にご自分で予約済です。');
        // return view('top'); 
        return redirect()->route('mypage.index');
    }

  }


  public function cancel($id){
    $event = EventUser::where('event_id',$id)
    ->where('user_id',Auth::id())
    ->latest()
    ->first();

    $event->canceled_date = CarbonImmutable::now()->format('Y-m-d H:i:s');
    $event->save();
    
    return redirect()->route('mypage.index')->with('status','キャンセルしました。');
  }




}
