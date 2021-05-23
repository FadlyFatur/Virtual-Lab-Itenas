<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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
Route::post('/home/post-laporan', 'HomeController@postAnggaran')->name('post-laporan');
Route::get('/home/download-laporan/{file}', 'HomeController@downloadLaporan')->name('download-laporan');
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
Route::get('get-list-materi/{id}','MateriController@getListMateri')->name('getListMateri');
Route::post('delete-materi/{id}','MateriController@deleteMateri')->name('deleteMateri');
Route::post('delete-detail-materi/{id}','MateriController@deleteDetailMateri')->name('delete-detailMateri');
Route::post('add-absen','MateriController@addAbsen')->name('addAbsen');
Route::post('absen','MateriController@absen')->name('absen');
Route::get('praktikum/kelas/download/{file}','MateriController@downloadFile')->name('downloadFile');
Route::get('download-tugas/{file}','MateriController@downloadTugas')->name('downloadTugas');
Route::get('absen','MateriController@ExportAbsen')->name('rekapAbsen');
Route::post('tugas','MateriController@inputTugas')->name('inputTugas');
Route::get('list-tugas/{id}','MateriController@indexTugas')->name('Tugas');
Route::get('list-tugas/get-list-tugas/{id}','MateriController@getTugas')->name('get-tugas');
Route::get('list-tugas/updateNilai/{id}','MateriController@updateNilai')->name('update-nilai');


Route::get('get-rekrutmen/{id}', 'RekrutmenController@getDetailrekrut')->name('get-detail-rekrut');
Route::post('post-rekrutmen-user', 'RekrutmenController@postDetailrekrut')->name('post-detail-rekrut');
Route::get('get-list-prak/{id}', 'AdminController@getPrak')->name('get-list-prak');
Route::get('get-list-rekrut/{id}', 'RekrutmenController@getRekrut')->name('get-list-rekrut');

// admin controller 
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function (){
    Route::get('/', 'AdminController@index')->name('dashboard')->middleware('admin');
    Route::get('get-lab-list/{id}', 'AdminController@getListLab')->name('get-prak-rekrut');

    Route::get('get-prak-rekrut/{id}', 'RekrutmenController@getPrak')->name('get-prak-rekrut');
    Route::get('rekrutmen/download/{file}','RekrutmenController@downloadFileRekrut')->name('downloadFileRekrut');
    Route::get('status-rekrutmen/{id}', 'RekrutmenController@statusRekrutmen')->name('ganti-status-rekrutmen');

    Route::post('delete-jurusan/{id}', 'AdminController@deleteJurusan')->name('delete-jurusan');
    Route::get('status-jurusan/{id}', 'AdminController@statusJurusan')->name('ganti-status-jurusan');
    
    Route::post('post-berita', 'AdminController@postBerita')->name('post-berita');
    Route::post('hapus-berita/{id}', 'AdminController@hapusBerita')->name('hapus-berita');

    Route::get('jurusan', 'AdminController@indexJurusan')->name('jurusan-admin')->middleware('admin');
    Route::get('jurusan/json', 'AdminController@getJurusan')->name('get-jurusan');
    Route::post('jurusan/post-jurusan', 'AdminController@postJurusan')->name('post-jurusan');
    Route::get('/edit-jurusan/{id}', 'AdminController@indexEditJurusan')->name('edit-jurusan');
    Route::post('/edit-jurusan/{id}/submit', 'AdminController@postEditJurusan')->name('post-edit-jurusan');

    
    Route::prefix('laboratorium')->group(function (){
        Route::get('/', 'AdminController@indexLab')->name('laboratorium')->middleware('admin');
        Route::get('json', 'AdminController@getTableLab')->name('get-Lab');
        Route::post('post-lab', 'AdminController@postLab')->name('post-Lab');
        Route::get('/edit-lab/{id}', 'AdminController@indexEditLab')->name('edit-lab');
        Route::post('/edit-lab/{id}/submit', 'AdminController@postEditLab')->name('post-edit-lab');
    });
    
    Route::get('status-lab/{id}', 'AdminController@statusLab')->name('status-Lab');
    Route::post('delete-lab/{id}', 'AdminController@deleteLab')->name('delete-Lab');

    Route::prefix('praktikum')->group(function (){
        Route::get('{slug}', 'AdminController@indexPrak')->name('praktikumAdmin')->middleware('admin');
        Route::get('get-data/{id}', 'AdminController@getTablePrak')->name('get-praktikum');
        Route::post('post-praktikum/{id}', 'AdminController@postPrak')->name('post-praktikum');
        Route::get('status-prak/{id}', 'AdminController@statusPrak')->name('status-prak');
        Route::post('delete-prak/{id}', 'AdminController@deletePrak')->name('delete-Prak');

        Route::prefix('materi')->group(function (){
            Route::get('{id}', 'AdminController@indexMateri')->name('materi');
            Route::get('get-data/{id}', 'AdminController@getMateri')->name('get-materi');
            Route::post('post-materi/{id}', 'AdminController@postMateri')->name('post-materi');
            Route::post('post-detail-materi', 'AdminController@postDetailMateri')->name('post-Detail-materi');
            Route::post('post-kelas', 'AdminController@postKelas')->name('post-kelas');

            Route::get('status-materi/{id}', 'AdminController@materiStatus')->name('status-materi');
            Route::post('delete-materi/{id}', 'AdminController@deleteMateri')->name('delete-materi');
        });
    });

    Route::prefix('rekrutmen')->group(function (){
        Route::get('/', 'RekrutmenController@indexRek')->name('rekrutmen')->middleware('admin');
        Route::get('get-rekrutmen-admin', 'RekrutmenController@getTableRek')->name('get-rekrutmen-admin');
        Route::post('/post-rekrutmen', 'RekrutmenController@postRekrut')->name('post-rekrutmen');
        Route::get('/list-rekrutmen/{id}', 'RekrutmenController@getListRekrut')->name('get-list-rekrutmen');
        Route::get('/get-detail-rekrutmen/{id}', 'RekrutmenController@getUserRekrut')->name('get-user-rekrutmen');
        Route::get('{id}/rekrutmen-accept/{userId}', 'RekrutmenController@acceptRekrut')->name('rekrutmen-accept');
        Route::get('{id}/rekrutmen-denied/{userId}', 'RekrutmenController@deniedRekrut')->name('rekrutmen-denied');
    });
    
    Route::get('/user', 'UserController@indexUser')->name('user')->middleware('admin');
    Route::get('/user/json', 'UserController@getUserData')->name('get-user');
    Route::post('edit-user/{id}', 'UserController@postEditUser')->name('post-edit-user');
    Route::get('get-user-detail/{id}', 'UserController@getUserDetail')->name('get-user-detail');

    Route::get('/mahasiswa', 'UserController@indexMahasiswa')->name('mahasiswa')->middleware('admin');
    Route::get('/mahasiswa/json', 'UserController@getMahasiswa')->name('get-mahasiswa');
    Route::post('/mahasiswa/import_excel', 'UserController@impotMahasiswa')->name('import-mahasiswa');
    Route::post('/mahasiswa/post-mahasiswa', 'UserController@postMahasiswa')->name('post-mahasiswa');
    Route::post('/mahasiswa/hapus-mahasiswa/{id}', 'UserController@hapusMahasiswa')->name('hapus-mahasiswa');

    Route::get('/dosen', 'UserController@indexDosen')->name('dosen')->middleware('admin');
    Route::get('/dosen/json', 'UserController@getDosen')->name('get-dosen');
    Route::post('/dosen/import_excel', 'UserController@importDosen')->name('import-dosen');
    Route::post('/dosen/post-dosen', 'UserController@postDosen')->name('post-dosen');
    Route::post('/dosen/hapus-dosen/{id}', 'UserController@deleteDosen')->name('delete-dosen');
    Route::post('edit-dosen/{id}', 'UserController@postEditDosen')->name('post-edit-dosen');
    Route::get('get-dosen-detail/{id}', 'UserController@getDosenDetail')->name('get-dosen-detail');

    Route::get('/berita', 'AdminController@indexBerita')->name('Berita')->middleware('admin');
    Route::get('/berita/get-berita', 'AdminController@getBerita')->name('get-Berita');
    Route::get('/berita/status-berita/{id}', 'AdminController@statusBerita')->name('status-Berita');
    Route::get('/asisten', 'AdminController@indexAsisten')->name('asisten');
    Route::post('/hapus-asisten/{id}', 'AdminController@hapusAsisten')->name('hapus-asisten');
    Route::get('/get-asisten', 'AdminController@indexAsisten')->name('asisten');
    Route::post('/post-asisten', 'AdminController@postAssisten')->name('post-assisten');

});
