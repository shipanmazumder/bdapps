<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'admin','middleware'=>['admin','auth'],'namespace'=>'Admin','as'=>'admin.'],function() {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::group(['prefix'=>'user','middleware'=>['user','auth'],'namespace'=>'User','as'=>'user.'],function(){

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/instruction', 'InstructionController@index')->name('instruction');
//    Route::get('/install', 'InstallAppController@index')->name('install');

    Route::resource("installapp",'InstallAppController')->names([
        'index' => 'install',
    ])->except([
        'create','store','destroy','show','edit','update','destroy'
    ]);
    Route::post('/install', 'InstallAppController@store');
    Route::get('/faq-generator', 'FaqController@index')->name('faq');
    Route::post('/faq_generator', 'FaqController@faqGenerator');

});
