<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RichmemoController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.index');
Route::get('/user', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('user.exec.register');

Route::group(['middleware' => ['auth']], function() {
Route::get('/memo', [MemoController::class, 'index'])->name('memo.index');
Route::get('/memo/add', [MemoController::class, 'add'])->name('memo.add');
Route::get('/memo/select',[MemoController::class,'select'])->name('memo.select');
Route::post('/memo/update', [MemoController::class, 'update'])->name('memo.update');
Route::post('/memo/delete', [MemoController::class, 'delete'])->name('memo.delete');
Route::get('logout', [LoginController::class, 'logout'])->name('memo.logout');
});

Route::group(['middleware'=>['auth']],function(){
Route::get('/richmemo',[RichmemoController::class,'index'])->name('richmemo.index');
Route::get('/richmemo/add', [RichmemoController::class, 'add'])->name('richmemo.add');
Route::get('/richmemo/select',[RichmemoController::class,'select'])->name('richmemo.select');
Route::post('/richmemo/update', [RichmemoController::class, 'update'])->name('richmemo.update');
Route::post('/richmemo/delete', [RichmemoController::class, 'delete'])->name('richmemo.delete');
// Route::get('logout', [LoginController::class, 'logout'])->name('richmemo.logout');
});

Auth::routes();


