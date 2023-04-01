<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;


class MagicWordService
{

  public static function kind($num){

    if($num === 1){
      return "コートレンタル";
    }

    if($num === 5){
      return "通常イベント";
    }

  }


}
