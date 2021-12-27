<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\listcontroller;
use App\Http\Controllers\acceptcontroller;

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

Route::get('/', function () {
    if (!isset(Auth::user()->name)) {
        return view('welcome',[
            "title" => "Welcome"
        ]);
    }else{
        return redirect("user/list");
    }
});
Route::get('/login', [authcontroller::class,'page'])->name('login');
Route::get('/list/accept', function () {
    return view('after.accept',[
    	"title" => "Accept"
    ]);
});
Route::get('/register', function () {
    return view('register',[
    	"title" => "register"
    ]);
});

Route::post('login/process', [authcontroller::class, 'authenticate']);
Route::post('register/process', [authcontroller::class, 'register']);

Route::group(['prefix'=>'user', 'middleware'=>'auth'],function(){
    Route::get('/list', [listcontroller::class, 'index']);
    Route::get('/list/accept', [acceptcontroller::class, 'index']);
    Route::post('/logout/process', [authcontroller::class, 'logout']);
    Route::get('/list/accept/choice', [acceptcontroller::class, 'choice']);
    Route::post('/list/accept/simpanajax', [acceptcontroller::class, 'store']);
    Route::get('/list/accept/choice/essay',[acceptcontroller::class, 'essay']);
});