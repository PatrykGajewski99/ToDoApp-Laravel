<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;
use App\Models\Roll;
use App\Http\Controllers\WelcomePageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(WelcomePageController::class)->group(function(){

    Route::get('/','show')->name('welcome');
});

Route::get('/showTasks/{id}','App\Http\Controllers\WelcomePageController@showTask');

require __DIR__.'/auth.php';

Route::get('/addList', function () {
    return view('addList');
})->middleware(['auth', 'verified'])->name("lists.create");


Route::controller(ListController::class)->middleware(['auth', 'verified'])->group(function (){

    Route::get("/dashboard",'show')->name('dashboard');
    Route::post("addList",'store')->name('lists.store');
    Route::delete("/delete-list/{id}",'destroy')->name('destroy.list');
    Route::get("/edit-list/{id}",'edit');
    Route::patch('/update-list/{id}','update');
});

Route::controller(TaskController::class)->middleware(['auth', 'verified'])->group(function (){
    Route::get("/add-task/{id}",'create')->name('add.task');
    Route::post("add-task/{id}",'store')->name('task.store');
    Route::get("/show-task/{id}",'show')->name('add.task');
    Route::delete("/delete-task/{id}",'destroy')->name('destroy.task');
    Route::get("/edit-task/{id}",'edit');
    Route::patch('/update-task/{id}','update');
});
