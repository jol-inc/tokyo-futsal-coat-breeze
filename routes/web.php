<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerEventController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::post('events/calendar-change', [EventController::class, 'calendarChange'])->name('events.calendar.change');

// Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');
// Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('manager')
->middleware('can:manager-higher')->group(function(){

 Route::get('/', [ManagerController::class, 'index'])->name('manager.index');

 Route::get('events/past', [ManagerEventController::class, 'past'])->name('manager.events.past');

 Route::get('events', [ManagerEventController::class, 'index'])->name('manager.events.index');
 Route::get('events/create', [ManagerEventController::class, 'create'])->name('manager.events.create');
 Route::post('events/store', [ManagerEventController::class, 'store'])->name('manager.events.store');
 Route::get('events/{event}', [ManagerEventController::class, 'show'])->name('manager.events.show');
 Route::get('events/{event}/edit', [ManagerEventController::class, 'edit'])->name('manager.events.edit');
 Route::put('events{event}', [ManagerEventController::class, 'update'])->name('manager.events.update');
 Route::delete('events{event}', [ManagerEventController::class, 'destroy'])->name('manager.events.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
