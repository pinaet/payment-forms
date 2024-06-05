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

Route::get('/', function () { return view('welcome');});

/** events and tickets 
 * requirement
 * 1. ticket ของแต่ละ event ไม่ปนกัน
 *  - แยกด้วย URL
 *  - ทำตารางแยกกัน events, tickets
 *  - รองรับ parameters ที่ URL
 * 2. ประเภทการเซ็ตราคาของ ticket
 *  - fixed priced
 *  - variable priced
 * 3. auto generated id - reference_order
 * 4. กำหนดให้ payment method คิด service fee หรือไม่
*/
Route::get( '/event/{event_id}', 'EventsController@index');
Route::get( '/event/{event_id}/{ticket_id}', 'EventsController@index');
Route::post('/event/store', 'EventsController@store');
Route::post('/event/order-notify', 'EventsController@orderNotify');
Route::get('/event-report/{event_id}', 'EventsController@report');

/** alumni */
Route::get('/alumni', 'AlumniController@index');
Route::post('/alumni/store', 'AlumniController@store');
Route::post('/alumni/email', 'AlumniController@email');
Route::get('/alumni/E3615D00-37B9-460A-B91D-7DEB45378358', 'AlumniController@report');//E3615D00-37B9-460A-B91D-7DEB45378358
Route::post('/alumni/report/update', 'AlumniController@report_update');

/** school fee */
Route::get('/school-fee', 'SchoolFeesController@index');
Route::post('/school-fee/check-parent', 'SchoolFeesController@checkParent');
Route::post('/school-fee/store', 'SchoolFeesController@store');
Route::post('/school-fee/order-notify', 'SchoolFeesController@orderNotify');

/** application fee */
Route::get( '/application-fee', 'ApplicationFeeController@index');
Route::get( '/application-fee/{student_name}', 'ApplicationFeeController@index');
Route::post('/application-fee/check-student', 'ApplicationFeeController@checkStudent');
Route::post('/application-fee/store', 'ApplicationFeeController@store');
Route::post('/application-fee/order-notify', 'ApplicationFeeController@orderNotify');
Route::get( '/application-fee/test/index', 'TestsController@index');