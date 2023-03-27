<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Services\EventService;

class ManagerEventController extends Controller
{


  public function index(){

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
    function($join){
    $join->on('events.id', '=', 'reservedPeople.event_id');
    })

    ->whereDate('start_date','>=',$today)
    ->orderBy('start_date','asc')
    ->paginate(10);

    return view('manager.events.index',compact('events'));
  }



}
