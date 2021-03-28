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
Route::get('/profil', 'landingController@profil')->name('profil');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/jurusan', 'landingController@indexJurusan')->name('jurusan');


Route::prefix('pengajar')->group(function () {
    Route::get('/', 'landingController@indexPengajar')->name('pengajar');
    Route::get('/detail-pengajar', 'landingController@indexPengajar')->name('pengajar');
});

Route::prefix('berita')->group(function () {
    Route::get('/', 'landingController@indexBerita')->name('berita');
    Route::get('/{slug}', 'landingController@detailBerita')->name('detailBerita');
});

Route::group(['middleware' => 'auth', 'verified'], function () {
    Route::get('rekrutmen', 'landingController@indexRekrutmen')->name('rekrutmen');
    Route::get('rekrutmen/download/{file}','landingController@downloadFileSyarat')->name('downloadFileSyarat');
});

Route::get('laboratorium/{slug}', 'landingController@indexlaboratorium')->name('lab');

Route::group(['prefix' => 'praktikum'], function () {
    Route::get('/{slug}', 'MateriController@listPraktikum')->name('praktikum-list')->middleware('auth');
    Route::get('/kelas/{id}', 'MateriController@indexMateri')->name('detail-materi');
    Route::get('/daftar/{id}', 'MateriController@daftarPrak')->name('daftar-prak')->middleware('auth');
});

Route::get('get-materi/{id}','MateriController@getMateri')->name('getMateri');
Route::post('delete-materi/{id}','MateriController@deleteMateri')->name('deleteMateri');
Route::post('add-absen','MateriController@addAbsen')->name('addAbsen');
Route::post('absen','MateriController@absen')->name('absen');
Route::get('praktikum/kelas/download/{file}','MateriController@downloadFile')->name('downloadFile');
Route::get('download-tugas/{file}','MateriController@downloadTugas')->name('downloadTugas');
Route::get('absen','MateriController@ExportAbsen')->name('rekapAbsen');
Route::post('tugas','MateriController@inputTugas')->name('inputTugas');
Route::get('list-tugas/{id}','MateriController@indexTugas')->name('Tugas');
Route::get('list-tugas/get-list-tugas/{id}','MateriController@getTugas')->name('get-tugas');
Route::get('list-tugas/updateNilai/{id}','MateriController@updateNilai')->name('update-nilai');


Route::get('get-rekrutmen/{id}', 'AdminController@getDetailrekrut')->name('get-detail-rekrut');
Route::post('post-rekrutmen-user', 'AdminController@postDetailrekrut')->name('post-detail-rekrut');
Route::get('get-list-prak/{id}', 'AdminController@getPrak')->name('get-list-prak');
Route::get('get-list-rekrut/{id}', 'AdminController@getRekrut')->name('get-list-rekrut');

// admin controller 
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::get('get-prak-rekrut/{id}', 'AdminController@getPrak')->name('get-prak-rekrut');
    Route::get('rekrutmen/download/{file}','AdminController@downloadFileRekrut')->name('downloadFileRekrut');

    Route::post('delete-jurusan/{id}', 'AdminController@deleteJurusan')->name('delete-jurusan');
    Route::get('status-jurusan/{id}', 'AdminController@statusJurusan')->name('ganti-status-jurusan');
    
    Route::post('post-berita', 'AdminController@postBerita')->name('post-berita');

    Route::get('jurusan', 'AdminController@indexJurusan')->name('jurusan');
    Route::get('jurusan/json', 'AdminController@getJurusan')->name('get-jurusan');
    Route::post('jurusan/post-jurusan', 'AdminController@postJurusan')->name('post-jurusan');
    
    Route::prefix('laboratorium')->group(function (){
        Route::get('/', 'AdminController@indexLab')->name('laboratorium');
        Route::get('json', 'AdminController@getTableLab')->name('get-Lab');
        Route::post('post-lab', 'AdminController@postLab')->name('post-Lab');
    });
    
    Route::post('delete-lab/{id}', 'AdminController@deleteLab')->name('delete-Lab');

    Route::prefix('praktikum')->group(function (){
        Route::get('{slug}', 'AdminController@indexPrak')->name('praktikumAdmin');
        Route::get('get-data/{id}', 'AdminController@getTablePrak')->name('get-praktikum');
        Route::post('post-praktikum/{id}', 'AdminController@postPrak')->name('post-praktikum');

        Route::prefix('materi')->group(function (){
            Route::get('{id}', 'AdminController@indexMateri')->name('materi');
            Route::get('get-data/{id}', 'AdminController@getMateri')->name('get-materi');
            Route::post('post-materi/{id}', 'AdminController@postMateri')->name('post-materi');
            Route::post('post-detail-materi', 'AdminController@postDetailMateri')->name('post-Detail-materi');
            Route::post('post-kelas', 'AdminController@postKelas')->name('post-kelas');
        });
    });

    Route::prefix('rekrutmen')->group(function (){
        Route::get('/', 'AdminController@indexRek')->name('rekrutmen');
        Route::get('get-rekrutmen-admin', 'AdminController@getTableRek')->name('get-rekrutmen-admin');
        Route::post('/post-rekrutmen', 'AdminController@postRekrut')->name('post-rekrutmen');
        Route::get('/list-rekrutmen/{id}', 'AdminController@getListRekrut')->name('get-list-rekrutmen');
        Route::get('/get-detail-rekrutmen/{id}', 'AdminController@getUserRekrut')->name('get-user-rekrutmen');
        Route::get('{id}/rekrutmen-accept/{userId}', 'AdminController@acceptRekrut')->name('rekrutmen-accept');
        Route::get('{id}/rekrutmen-denied/{userId}', 'AdminController@deniedRekrut')->name('rekrutmen-denied');
    });
    
    Route::get('/user', 'AdminController@indexUser')->name('user');
    Route::get('/user/json', 'AdminController@getUserData')->name('get-user');

    Route::get('/mahasiswa', 'AdminController@indexMahasiswa')->name('mahasiswa');
    Route::get('/mahasiswa/json', 'AdminController@getMahasiswa')->name('get-mahasiswa');
    Route::post('/mahasiswa/import_excel', 'AdminController@impotMahasiswa')->name('import-mahasiswa');

    Route::get('/dosen', 'AdminController@indexDosen')->name('dosen');
    Route::get('/dosen/json', 'AdminController@getDosen')->name('get-dosen');
    Route::post('/dosen/import_excel', 'AdminController@impotDosen')->name('import-dosen');

    Route::get('/berita', 'AdminController@indexBerita')->name('Berita');
    Route::get('/berita/get-berita', 'AdminController@getBerita')->name('get-Berita');
    Route::get('/asisten', 'AdminController@indexAsisten')->name('asisten');

});
