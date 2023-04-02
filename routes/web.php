<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventReservationController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\CoatReservationController;
use Illuminate\Support\Facades\Route;



// ＴＯＰページ
Route::get('/', function () {
    return view('top');
})->name('/');


// カレンダー
Route::get('events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::get('events/calendar-change', [EventController::class, 'calendarChange'])->name('events.calendar-change');
// イベント詳細
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');


//通常イベント予約
Route::middleware('can:customer-higher','auth')->group(function(){
  Route::post('event-reservation/{event}', [EventReservationController::class, 'reserve'])->name('event-reservation.reserve');
  Route::post('event-reservation/{event}/cancel', [EventReservationController::class, 'cancel'])->name('event-reservation.cancel');
});


// コートレンタル
Route::get('coat-reservation', [CoatReservationController::class, 'index'])->name('coat-reservation.index');
// Route::get('coat-reservation/reserve', [CoatReservationController::class, 'reserve'])->name('coat-reservation.reserve');
Route::post('coat-reservation', [CoatReservationController::class, 'store'])->name('coat-reservation.store');
Route::post('coat-reservation/{event}/cancel', [CoatReservationController::class, 'cancel'])->name('coat-reservation.cancel');


// マイページ
Route::prefix('mypage')
// ->middleware(['auth','can:user-higher'])
->middleware(['auth'])
->group(function(){
  Route::get('/', [MypageController::class, 'index'])->name('mypage.index');
  Route::get('events', [MypageController::class, 'events'])->name('mypage.events');
});


// マネージャー以上
Route::prefix('manager')
->middleware('auth','can:manager-higher')->group(function(){

 //ManagerController
 Route::get('/', [ManagerController::class, 'index'])->name('manager.index');

 //ここからManagerEventController
 Route::get('events/past', [ManagerEventController::class, 'past'])->name('manager.events.past');

 Route::get('events', [ManagerEventController::class, 'index'])->name('manager.events.index');
 Route::get('events/create', [ManagerEventController::class, 'create'])->name('manager.events.create');
 Route::post('events', [ManagerEventController::class, 'store'])->name('manager.events.store');
 Route::get('events/{event}', [ManagerEventController::class, 'show'])->name('manager.events.show');
 Route::get('events/{event}/edit', [ManagerEventController::class, 'edit'])->name('manager.events.edit');
 Route::put('events{event}', [ManagerEventController::class, 'update'])->name('manager.events.update');
 Route::delete('events{event}', [ManagerEventController::class, 'destroy'])->name('manager.events.destroy');
});



// プロフィール
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
