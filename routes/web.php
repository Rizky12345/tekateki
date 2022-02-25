<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\listcontroller;
use App\Http\Controllers\acceptcontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\sadmincontroller;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->level == 'user'){
            return redirect('user');
        }if(Auth::user()->level == 'admin'){
            return redirect('admin');
        }if(Auth::user()->level == 'super admin'){
            return redirect('s/admin');
        }
    }
});
Route::get('/break', function () {
    return view("after/break");
});
Route::get('/login', [authcontroller::class,'page'])->name('login');
Route::get('/register', function () {
    return view('register',[
    	"title" => "register"
    ]);
});

Route::post('login/process', [authcontroller::class, 'authenticate']);
Route::post('register/process', [authcontroller::class, 'register']);

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', function(){
        if (Auth::user()->level == 'user'){
            return redirect('user');
        }if(Auth::user()->level == 'admin'){
            return redirect('admin');
        }if(Auth::user()->level == 'super admin'){
            return redirect('s/admin');
        }
    });

    Route::group(['prefix'=>'user', 'middleware'=>'level'], function() {
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

    Route::group(['prefix'=>'admin', 'middleware'=>'level'],function(){
        Route::get('/', [admincontroller::class, 'index']);
        Route::post('/logout', [authcontroller::class, 'logout']);
        Route::get('/ujian', [admincontroller::class, 'ujian']);
        Route::get('/ujian/{code}', [admincontroller::class, 'detail']);
        Route::post('/ujian/{code}/timeujian', [admincontroller::class, 'timeujian']);
        Route::get('/ujian/{code}/edit', [admincontroller::class, 'editsoal']);
        Route::post('/ujian/{code}/edit/p', [admincontroller::class, 'edits']);
        Route::post('/ujian/{code}/edit/pilihan', [admincontroller::class, 'editspilihan']);
        Route::post('/ujian/{code}/edit/image', [admincontroller::class, 'imageedit']);
        Route::post('/ujian/{code}/edit/tambahsoal', [admincontroller::class, 'tambahsoal']);
        Route::post('/ujian/{code}/edit/tambahpilihan', [admincontroller::class, 'tambahpilihan']);
        Route::post('/ujian/{code}/edit/kuncijawaban', [admincontroller::class, 'kuncijawaban']);
        Route::post('/ujian/{code}/edit/type', [admincontroller::class, 'type']);
        Route::post('/ujian/{code}/edit/typedeletesoal', [admincontroller::class, 'typedeletesoal']);
        Route::post('/ujian/{code}/edit/typedeletepilihan', [admincontroller::class, 'typedeletepilihan']);
        Route::post('/ujian/{code}/edit/destroyimage', [admincontroller::class, 'destroyimage']);

    });
    Route::group(['prefix'=>'s/admin', 'middleware'=>'level'],function(){
        Route::get('/', [sadmincontroller::class, 'index']);
        Route::post('/logout', [authcontroller::class, 'logout']);
    });

});
