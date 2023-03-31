<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoatReservationController extends Controller
{
    public function index(){
      return view('coat-reservation.index');
    }

    public function create(){
      return view('coat-reservation.create');
    }

    public function cancel($event){
      dd('キャンセル');
    }
}
