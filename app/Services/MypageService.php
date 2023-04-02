<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;


class MypageService
{

  static function when_events($events,$string){

    if($string === 'from_today_events'){
      return $events
      ->where('start_date', '>=', CarbonImmutable::today()->format('Y-m-d H:i:s'))
      ->sortBy('start_date');
    }

    if($string === 'past_events'){
      return $events
      ->where('start_date', '<', CarbonImmutable::today()->format('Y-m-d H:i:s'))
      ->sortByDesc('start_date');
    }

  }


}