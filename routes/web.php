<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\listcontroller;
use App\Http\Controllers\acceptcontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\sadmincontroller;
use App\Http\Controllers\testercontroller;
use App\Http\Controllers\ujiancontroller;
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
            Route::post('/{random}/testessay', [acceptcontroller::class, 'testessay']);
            Route::get('/{random}?page={number}', [acceptcontroller::class, 'getjawaban']);
            Route::get('/{random}', [acceptcontroller::class, 'choice']);
            Route::get('/{random}/destroy', [acceptcontroller::class, 'destroy']);
        });
    });

    Route::group(['prefix'=>'admin', 'middleware'=>'level'],function(){
        Route::group(['middleware'=>'sessionExistAdmin'],function(){
            Route::get('/', [admincontroller::class, 'index']);
            Route::post('/logout', [authcontroller::class, 'logout']);

            Route::group(['prefix' => 'ujian'], function() {
                Route::get('/', [ujiancontroller::class, 'ujian']);
                Route::get('/ujianmonitoring', [admincontroller::class, 'ujianmonitoring']);
                Route::get('/ujianmonitoring/{code}', [admincontroller::class, 'montoringcode']);
                 Route::get('/ujianmonitoring/{code}/{user}', [admincontroller::class, 'montoringcode']);
                Route::get('/create', [ujiancontroller::class, 'create']);
                Route::post('/create/process', [ujiancontroller::class, 'createprocess']);
                Route::get('/{code}', [ujiancontroller::class, 'detail']);
                Route::get('/{code}/tester', [testercontroller::class, 'tester']);
                Route::get('/{code}/tester/accept', [testercontroller::class, 'redirect_choice']);
                Route::post('/{code}/repeat', [ujiancontroller::class, 'repeat']);
                 Route::post('/{code}/kelas', [ujiancontroller::class, 'kelas']);
                 Route::post('/{code}/judul', [ujiancontroller::class, 'judul']);
                Route::post('/{code}/timeujian', [ujiancontroller::class, 'timeujian']);
                Route::get('/{code}/edit', [ujiancontroller::class, 'editsoal']);
                Route::post('/{code}/edit/p', [ujiancontroller::class, 'edits']);
                Route::post('/{code}/edit/pilihan', [ujiancontroller::class, 'editspilihan']);
                Route::post('/{code}/edit/image', [ujiancontroller::class, 'imageedit']);
                Route::post('/{code}/edit/tambahsoal', [ujiancontroller::class, 'tambahsoal']);
                Route::post('/{code}/edit/tambahpilihan', [ujiancontroller::class, 'tambahpilihan']);
                Route::post('/{code}/edit/kuncijawaban', [ujiancontroller::class, 'kuncijawaban']);
                Route::post('/{code}/edit/type', [ujiancontroller::class, 'type']);
                Route::post('/{code}/edit/typedeletesoal', [ujiancontroller::class, 'typedeletesoal']);
                Route::post('/{code}/edit/typedeletepilihan', [ujiancontroller::class, 'typedeletepilihan']);
                Route::post('/{code}/edit/destroyimage', [ujiancontroller::class, 'destroyimage']);


            });
        });
        Route::group(['prefix' => 'ujian'], function() {
            Route::group(['middleware'=>'accept'], function() {
                Route::post('/{code}/tester/{random}/post', [acceptcontroller::class, 'store']);
                Route::post('/{code}/tester/{random}/testessay', [acceptcontroller::class, 'testessay']);
                Route::get('/{code}/tester/{random}?page={number}', [acceptcontroller::class, 'getjawaban']);
                Route::get('/{code}/tester/{random}', [testercontroller::class, 'choice']);
                Route::get('/{code}/tester/{random}/destroy', [acceptcontroller::class, 'destroy']);
            });
        });
    });

    Route::group(['prefix'=>'s/admin', 'middleware'=>'level'],function(){
        Route::get('/', [sadmincontroller::class, 'index']);
        Route::post('/logout', [authcontroller::class, 'logout']);
    });

});
