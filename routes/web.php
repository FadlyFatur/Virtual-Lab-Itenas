<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => true]);
Route::get('/', 'landingController@landing')->name('landing');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/jurusan', 'landingController@indexJurusan')->name('jurusan');
Route::get('/detail-berita', 'landingController@detailBerita')->name('detail-berita');

Route::prefix('pengajar')->group(function () {
    Route::get('/', 'landingController@indexPengajar')->name('pengajar');
    Route::get('/detail-pengajar', 'landingController@indexPengajar')->name('pengajar');
});

Route::prefix('berita')->group(function () {
    Route::get('/', 'landingController@indexBerita')->name('berita');
    Route::get('/detail-berita', 'landingController@indexBerita')->name('berita');
});

Route::group(['middleware' => 'auth', 'verified'], function () {
    Route::get('/rekrutmen', 'landingController@indexRekrutmen')->name('rekrutmen');
});

Route::get('laboratorium/{slug}', 'landingController@indexlaboratorium')->name('lab');

Route::group(['prefix' => 'praktikum'], function () {
    Route::get('/{slug}', 'MateriController@listPraktikum')->name('praktikum-list')->middleware('auth');
    Route::get('/kelas/{id}', 'MateriController@indexMateri')->name('detail-materi');
    Route::get('/daftar/{id}', 'MateriController@daftarPrak')->name('daftar-prak')->middleware('auth');
});

route::get('get-materi/{id}','MateriController@getMateri')->name('getMateri');
route::post('delete-materi/{id}','MateriController@deleteMateri')->name('deleteMateri');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');

    Route::get('jurusan', 'AdminController@indexJurusan')->name('jurusan');
    Route::get('jurusan/json', 'AdminController@getJurusan')->name('get-jurusan');
    Route::post('jurusan/post-jurusan', 'AdminController@postJurusan')->name('post-jurusan');
    
    Route::prefix('laboratorium')->group(function (){
        Route::get('/', 'AdminController@indexLab')->name('laboratorium');
        Route::get('json', 'AdminController@getLab')->name('get-Lab');
        Route::post('post-lab', 'AdminController@postLab')->name('post-Lab');
    });

    Route::prefix('praktikum')->group(function (){
        Route::get('{slug}', 'AdminController@indexPrak')->name('praktikum');
        Route::get('get-data/{id}', 'AdminController@getPrak')->name('get-praktikum');
        Route::post('post-praktikum/{id}', 'AdminController@postPrak')->name('post-praktikum');

        Route::prefix('materi')->group(function (){
            Route::get('{id}', 'AdminController@indexMateri')->name('materi');
            Route::get('get-data/{id}', 'AdminController@getMateri')->name('get-materi');
            Route::post('post-materi/{id}', 'AdminController@postMateri')->name('post-materi');
            Route::post('post-data-materi', 'AdminController@postDataMateri')->name('post-data-materi');
            Route::post('post-detail-materi', 'AdminController@postDetailMateri')->name('post-Detail-materi');
            Route::post('post-kelas', 'AdminController@postKelas')->name('post-kelas');
        });
    });

    Route::get('/rekrutmen', 'AdminController@indexRek')->name('rekrutmen');
    
    Route::get('/user', 'AdminController@indexUser')->name('user');
    Route::get('/user/json', 'AdminController@getUserData')->name('get-user');

    Route::get('/mahasiswa', 'AdminController@indexMahasiswa')->name('mahasiswa');
    Route::get('/mahasiswa/json', 'AdminController@getMahasiswa')->name('get-mahasiswa');

    Route::get('/dosen', 'AdminController@indexDosen')->name('dosen');
    Route::get('/dosen/json', 'AdminController@getDosen')->name('get-dosen');

    Route::get('/berita', 'AdminController@indexBerita')->name('Berita');
    Route::get('/asisten', 'AdminController@indexAsisten')->name('asisten');

});
