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

Route::get('/', 'Auth\LoginController@index');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('user', 'UserController')->middleware('is_admin');
    Route::resource('plant', 'PlantController')->middleware('is_admin');
    Route::resource('tna', 'TnaController')->middleware('is_admin');
    Route::resource('buyer', 'BuyerController')->middleware('is_admin');
    Route::resource('po', 'PoController');
    Route::resource('po-tna', 'PoTnaController');

    Route::post('/upload_file', 'PoController@uploadFile')->name('upload_file');
    Route::post('/delete_po', 'PoController@deletePo')->name('delete_po');
    Route::post('/search_po', 'PoController@searchPo')->name('search_po');
    Route::post('/assign_tna', 'PoController@assignTna')->name('assign_tna');
    Route::post('/assign_tna_detail', 'PoController@assignTnaDetail')->name('assign_tna_detail');
    Route::post('/change_plant', 'PoController@changePlant')->name('change_plant');
    Route::post('/change_ship_date', 'PoController@changeShipDate')->name('change_ship_date');
    Route::post('/shipment_info_update', 'PoController@shipmentInfoUpdate')->name('shipment_info_update');
    Route::post('/get_po_info', 'PoController@getPoInfo')->name('get_po_info');
    Route::get('/shipment_summary', 'PoController@shipmentSummaryReport')->name('shipment_summary');
    Route::post('/get_shipment_summary_data', 'PoController@getShipmentSummaryData')->name('get_shipment_summary_data');

    Route::post('/search_po_tna_tasks', 'PoTnaController@searchPoTnaTasks')->name('search_po_tna_tasks');
    Route::post('/complete_po_tna_term', 'PoTnaController@completePoTnaTerm')->name('complete_po_tna_term');
    Route::post('/set_po_tna_term_remarks', 'PoTnaController@setPoTnaTermRemarks')->name('set_po_tna_term_remarks');
});