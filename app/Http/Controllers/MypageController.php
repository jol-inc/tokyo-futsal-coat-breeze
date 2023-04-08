<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\MypageService;

class MypageController extends Controller
{


  public function index(){
    // この時点ではユーザーに紐づくキャンセルされてないイベント達
    $events = User::findOrFail(Auth::id())->events()
    ->withPivot('number_of_people')
    ->wherePivot('canceled_date',null)
    ->get();


    // Service から 本日以降、昨日以前 を取得
    $from_today_events = MypageService::when_events($events,'from_today_events');
    $past_events = MypageService::when_events($events,'past_events');


    return view('mypage.index',compact('from_today_events','past_events'));
  }


}
