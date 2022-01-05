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
        return redirect("user");
    }
});
Route::get('/login', [authcontroller::class,'page'])->name('login');
Route::get('/register', function () {
    return view('register',[
    	"title" => "register"
    ]);
});

Route::post('login/process', [authcontroller::class, 'authenticate']);
Route::post('register/process', [authcontroller::class, 'register']);

Route::group(['prefix'=>'user', 'middleware'=>'auth'],function(){
    Route::group(['middleware'=>'sessionexist'],function(){
        Route::get('/', [listcontroller::class, 'index'])->name('user');
        Route::get('/accept/select/{code}', [acceptcontroller::class, 'index']);
        Route::get('/accept/choice/{code}', [acceptcontroller::class, 'redirect_choice']);
        Route::post('/logout/process', [authcontroller::class, 'logout']);
    });
    Route::group(['prefix'=>'accept', 'middleware'=>'accept'],function(){
        Route::post('/{random}/test', [acceptcontroller::class, 'store']);
        Route::get('/{random}?page={number}', [acceptcontroller::class, 'getjawaban']);
        Route::get('/{random}', [acceptcontroller::class, 'choice']);
        Route::get('/{random}/destroy', [acceptcontroller::class, 'destroy']);
        

    });

});