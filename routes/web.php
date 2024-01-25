<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventReservationController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CoatReservationController;
use Illuminate\Support\Facades\Route;




// ＴＯＰページ
Route::get('/', function () {
    return view('top');
})->name('/');




// イベントカレンダー
Route::get('events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::get('events/calendar-change', [EventController::class, 'calendarChange'])->name('events.calendar-change');

// 店舗イベント詳細
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');


// 店舗イベント予約
Route::middleware('auth','can:customer-higher')->group(function(){
  Route::post('event-reservation/{event}', [EventReservationController::class, 'reserve'])->name('event-reservation.reserve');
  Route::post('event-reservation/{event}/cancel', [EventReservationController::class, 'cancel'])->name('event-reservation.cancel');
});




// コートレンタル

// メール認証をこのgroupに適用する場合（更にUser.phpを修正）
Route::middleware('auth','verified','can:customer-higher')

// メール認証をこのgroupに適用しない場合（更にUser.phpを修正）
// Route::middleware('auth','can:customer-higher')

->prefix('coat-reservation')
->controller(CoatReservationController::class)
->name('coat-reservation.')
->group(function(){
  Route::get('/', 'index')->name('index');
  Route::post('/','store')->name('store');
  Route::post('{event}/cancel','cancel')->name('cancel');
});




// マイページ

// メール認証をこのgroupに適用する場合（更にUser.phpを修正）
Route::middleware(['auth','verified','can:customer-higher'])

// メール認証をこのgroupに適用しない場合（更にUser.phpを修正）
// Route::middleware(['auth','can:customer-higher'])

->group(function(){
  Route::get('mypage', [MypageController::class, 'index'])->name('mypage.index');
});




  // ▼マネージャー
// Route::prefix('manager')
// ->middleware('auth','can:manager-higher')->group(function(){

//   Route::get('events/past', [ManagerEventController::class, 'past'])->name('manager.events.past');

//   Route::get('events', [ManagerEventController::class, 'index'])->name('manager.events.index');
//   Route::get('events/create', [ManagerEventController::class, 'create'])->name('manager.events.create');
//   Route::post('events', [ManagerEventController::class, 'store'])->name('manager.events.store');
//   Route::get('events/{event}', [ManagerEventController::class, 'show'])->name('manager.events.show');
//   Route::get('events/{event}/edit', [ManagerEventController::class, 'edit'])->name('manager.events.edit');
//   Route::put('events{event}', [ManagerEventController::class, 'update'])->name('manager.events.update');
//   Route::delete('events{event}', [ManagerEventController::class, 'destroy'])->name('manager.events.destroy');
// });
Route::middleware('auth','can:manager-higher')
->prefix('manager/events')
->controller(ManagerEventController::class)
->name('manager.events.')
->group(function(){

  Route::get('past', 'past')->name('past');

  Route::get('/','index')->name('index');
  Route::get('create','create')->name('create');
  Route::post('/','store')->name('store');
  Route::get('{event}','show')->name('show');
  Route::get('{event}/edit','edit')->name('edit');
  Route::put('{event}','update')->name('update');
  // Route::delete('{event}','destroy')->name('destroy');
});




// プロフィール

// メール認証をこのgroupに適用する場合（更にUser.phpを修正）
Route::middleware('auth','verified')->group(function () {

// メール認証をこのgroupに適用しない場合（更にUser.phpを修正）
// Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





//ファイル インクルード
require __DIR__.'/auth.php';
