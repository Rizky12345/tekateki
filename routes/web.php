<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\listcontroller;
use App\Http\Controllers\acceptcontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\acceptusercontroller;
use App\Http\Controllers\sadmincontroller;
use App\Http\Controllers\testercontroller;
use App\Http\Controllers\testersadmincontroller;
use App\Http\Controllers\ujiancontroller;
use App\Http\Controllers\allujiancontroller;
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


Route::post('login/process', [authcontroller::class, 'authenticate']);


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
            Route::get('/profile', [listcontroller::class, 'profile']);
            Route::post('/profile/ubah', [listcontroller::class, 'ubah']);
            Route::get('/nilai', [listcontroller::class, 'nilai']);
            Route::get('/nilai/{id}/{code}', [listcontroller::class, 'nilaicode']);
            Route::get('/accept/select/{code}', [acceptusercontroller::class, 'index']);

            Route::get('/accept/choice/{code}', [acceptusercontroller::class, 'redirect_choice']);
            Route::post('/logout/process', [authcontroller::class, 'logout']);
        });
        Route::group(['prefix'=>'accept', 'middleware'=>'accept'],function(){
            Route::post('/{random}/test', [acceptcontroller::class, 'store']);
            Route::post('/{random}/testessay', [acceptcontroller::class, 'testessay']);
            Route::get('/{random}?page={number}', [acceptcontroller::class, 'getjawaban']);
            Route::get('/{random}', [acceptusercontroller::class, 'choice']);
            Route::get('/{random}/destroy', [acceptcontroller::class, 'destroy']);
        });
    });

    Route::group(['prefix'=>'admin', 'middleware'=>'level'],function(){
        Route::group(['middleware'=>'sessionExistAdmin', 'middleware'=>'sessionujian'],function(){
            Route::get('/', [admincontroller::class, 'index']);
            Route::post('/logout', [authcontroller::class, 'logout']);
            Route::get('/naik_kelas', [admincontroller::class, 'naik_kelas']);
            Route::post('/naik_kelas/upgrade', [admincontroller::class, 'naik_kelas_upgrade']);
            Route::get('/jadwal', [admincontroller::class, 'jadwal']);
            Route::get('/user', [admincontroller::class, 'user']);
            Route::get('/murid/excel', [admincontroller::class, 'murid_excel']);
            Route::get('/user/murid', [admincontroller::class, 'user_murid']);
            Route::post('/user/proccess', [admincontroller::class, 'user_proccess']);
            Route::get('/jadwal/{id}', [admincontroller::class, 'jadwal_id']);
            Route::get('/user/{user_id}/{name}', [admincontroller::class, 'detailuser']);
            Route::post('/user/{user_id}/{name}/edit', [admincontroller::class, 'edituser']);
            Route::group(['prefix' => 'ujian'], function() {
                Route::get('/', [ujiancontroller::class, 'ujian']);
                Route::get('/ujianmonitoring', [admincontroller::class, 'ujianmonitoring']);
                Route::get('/ujianmonitoring/{code}', [admincontroller::class, 'montoringcode']);
                Route::get('/ujianmonitoring/{code}/{user}', [admincontroller::class, 'montoringcode']);
                Route::get('/create', [ujiancontroller::class, 'create']);
                Route::post('/create/process', [ujiancontroller::class, 'createprocess']);
                Route::get('/{code}', [ujiancontroller::class, 'detail']);
                Route::get('/{code}/docs', [ujiancontroller::class, 'docs_soal']);
                Route::get('/{code}/tester', [testercontroller::class, 'tester']);
                Route::get('/{code}/essay', [admincontroller::class, 'essay']);
                Route::post('/{code}/essay/point', [admincontroller::class, 'point']);
                Route::get('/{code}/tester/accept', [testercontroller::class, 'redirect_choice']);
                Route::get('/{code}/serahkan', [ujiancontroller::class, 'serahkan']);
                Route::get('/{code}/{user_id}/{nilai_id}', [ujiancontroller::class, 'periksa']);
                Route::post('/{code}/destroy', [ujiancontroller::class, 'destroy']);
                Route::post('/{code}/{user_id}/{nilai_id}/destroy', [ujiancontroller::class, 'nilai_destroy']);
                Route::post('/{code}/kelas', [ujiancontroller::class, 'kelas']);
                Route::post('/{code}/kkm', [ujiancontroller::class, 'kkm']);
                Route::post('/{code}/status', [ujiancontroller::class, 'status']);
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
                Route::get('/{code}/tester/{random}/tester?page={number}', [acceptcontroller::class, 'getjawaban']);
                Route::get('/{code}/tester/{random}/tester', [testercontroller::class, 'choice']);
                Route::get('/{code}/tester/{random}/destroy/tester', [acceptcontroller::class, 'destroy']);
            });
        });
    });Route::group(['prefix'=>'s/admin', 'middleware'=>'level'],function(){
        Route::group(['middleware'=>'sessionExistSadmin', 'middleware'=>'sessionujian'],function(){
            Route::get('/', [sadmincontroller::class, 'index']);
            Route::get('/{code}/generate', [sadmincontroller::class, 'generate_code']);
            Route::get('/mapel', [sadmincontroller::class, 'mapel']);
            Route::get('/jadwal/create', [sadmincontroller::class, 'jadwal_create']);
            Route::get('/jadwal/{id}', [sadmincontroller::class, 'jadwal_id']);
            Route::get('/jadwal/{id}/edit', [sadmincontroller::class, 'jadwal_id_edit']);
            Route::post('/jadwal/destroy/{id}', [sadmincontroller::class, 'jadwal_id_destroy']);
            Route::post('/jadwal/{id}/edit/proccess', [sadmincontroller::class, 'jadwal_id_edit_process']);
            Route::post('/jadwal/create/proccess', [sadmincontroller::class, 'jadwal_create_proccess']);
            Route::get('/jadwal', [sadmincontroller::class, 'jadwal']);
            Route::post('/mapel/tambah', [sadmincontroller::class, 'mapel_tambah']);
            Route::post('/mapel/destroy', [sadmincontroller::class, 'mapel_destroy']);

            Route::get('/user', [sadmincontroller::class, 'user']);
            Route::post('/user/{user_id}/{name}/edit', [sadmincontroller::class, 'edituser']);
            Route::get('/user/{user_id}/{name}', [sadmincontroller::class, 'detailuser']);

            Route::get('/user/alluser', [sadmincontroller::class, 'alluser']);
            Route::get('/naik_kelas', [sadmincontroller::class, 'naik_kelas']);
            Route::get('/naik_kelas/{id}', [sadmincontroller::class, 'naik_kelas_id']);
            Route::get('/naik_kelas/{id}/excel', [sadmincontroller::class, 'naik_kelas_id_excel']);
            Route::post('/naik_kelas/{id}/upgrade', [sadmincontroller::class, 'naik_kelas_id_upgrade']);
            Route::post('/user/cari', [sadmincontroller::class, 'usercari']);
            Route::post('/user/destroy', [sadmincontroller::class, 'destroy']);
            Route::post('/user/process', [sadmincontroller::class, 'userprocess']);
            Route::post('/logout', [authcontroller::class, 'logout']);
            Route::get('/semua_nilai', [sadmincontroller::class, 'semua_nilai']);
            Route::group(['prefix' => 'ujian'], function() {
                Route::get('/', [allujiancontroller::class, 'ujian']);
                Route::post('/filter_monitor', [allujiancontroller::class, 'filter_monitor']);
                Route::post('/filter_monitor_all', [allujiancontroller::class, 'filter_monitor_all']);
                Route::post('/filter', [allujiancontroller::class, 'filter']);
                Route::post('/filter_nilai', [allujiancontroller::class, 'filter_nilai']);
                Route::post('/filter_all', [allujiancontroller::class, 'filter_all']);
                Route::get('{code}/{user_id}/{nilai_id}', [allujiancontroller::class, 'periksa']);
                Route::post('{code}/{user_id}/{nilai_id}/destroy', [allujiancontroller::class, 'nilai_destroy']);
                Route::get('/all', [allujiancontroller::class, 'allujian']);
                Route::get('/ujianmonitoring', [sadmincontroller::class, 'ujianmonitoring']);
                Route::get('/ujianmonitoring/all', [sadmincontroller::class, 'allujianmonitoring']);
                Route::get('/ujianmonitoring/{code}', [sadmincontroller::class, 'montoringcode']);
                Route::get('/ujianmonitoring/{code}/{user}', [sadmincontroller::class, 'montoringcode']);
                Route::get('/create', [allujiancontroller::class, 'create']);
                Route::post('/create/process', [allujiancontroller::class, 'createprocess']);
                Route::get('/{code}', [allujiancontroller::class, 'detail']);
                Route::get('/{code}/docs', [ujiancontroller::class, 'docs_soal']);
                Route::get('/{code}/tester', [testersadmincontroller::class, 'tester']);
                Route::get('/{code}/essay', [sadmincontroller::class, 'essay']);
                Route::post('/{code}/essay/point', [sadmincontroller::class, 'point']);
                Route::get('/{code}/tester/accept/process', [testersadmincontroller::class, 'redirect_choice']);
                Route::get('/{code}/serahkan', [allujiancontroller::class, 'serahkan']);
                Route::post('/{code}/kelas', [allujiancontroller::class, 'kelas']);
                Route::post('/{code}/kkm', [allujiancontroller::class, 'kkm']);
                Route::post('/{code}/status', [allujiancontroller::class, 'status']);
                Route::post('/{code}/judul', [allujiancontroller::class, 'judul']);
                Route::post('/{code}/destroy', [allujiancontroller::class, 'destroy']);
                Route::post('/{code}/timeujian', [allujiancontroller::class, 'timeujian']);
                Route::group(['middleware' => 'editstop'], function() {
                    Route::get('/{code}/edit', [allujiancontroller::class, 'editsoal']);
                    Route::post('/{code}/edit/p', [allujiancontroller::class, 'edits']);
                    Route::post('/{code}/edit/pilihan', [allujiancontroller::class, 'editspilihan']);
                    Route::post('/{code}/edit/image', [allujiancontroller::class, 'imageedit']);
                    Route::post('/{code}/edit/tambahsoal', [allujiancontroller::class, 'tambahsoal']);
                    Route::post('/{code}/edit/tambahpilihan', [allujiancontroller::class, 'tambahpilihan']);
                    Route::post('/{code}/edit/kuncijawaban', [allujiancontroller::class, 'kuncijawaban']);
                    Route::post('/{code}/edit/type', [allujiancontroller::class, 'type']);
                    Route::post('/{code}/edit/typedeletesoal', [allujiancontroller::class, 'typedeletesoal']);
                    Route::post('/{code}/edit/typedeletepilihan', [allujiancontroller::class, 'typedeletepilihan']);
                    Route::post('/{code}/edit/destroyimage', [allujiancontroller::class, 'destroyimage']);
                });
            });
        });Route::group(['prefix' => 'ujian'], function() {
            Route::group(['middleware'=>'accept'], function() {
                Route::post('/{code}/tester/{random}/post', [acceptcontroller::class, 'store']);
                Route::post('/{code}/tester/{random}/testessay', [acceptcontroller::class, 'testessay']);
                Route::get('/{code}/tester/{random}?page={number}', [acceptcontroller::class, 'getjawaban']);
                Route::get('/{code}/tester/{random}/tester', [testersadmincontroller::class, 'choice']);
                Route::get('/{code}/tester/{random}/destroy/tester', [acceptcontroller::class, 'destroy']);
            });
        });
    });
});
