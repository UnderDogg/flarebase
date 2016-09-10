<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/tickets'], function () {

    Route::resource('tickets', 'TicketsController');
    /**
     * TICKETS
     */
    Route::get('/data', ['as' => 'tickets.data', 'uses' => 'TicketsController@anyData']);
    Route::patch('/updatestatus/{id}', 'TicketsController@updateStatus');
    Route::patch('/updateassign/{id}', 'TicketsController@updateAssign');
    Route::post('/updatetime/{id}', 'TicketsController@updateTime');
    Route::post('/invoice/{id}', 'TicketsController@invoice');
    Route::post('/comments/{id}', 'CommentController@store');
    Route::post('select_all', ['as' => 'select_all', 'uses' => 'TicketsController@select_all']);

    Route::get('/tickets/openperdepartment/{$department}', ['as' => 'dept.open.ticket', 'uses' => 'TicketsController@openticketsperdepartment']);
    Route::get('/tickets/inprogressperdepartment/{$department}', ['as' => 'dept.inprogress.ticket', 'uses' => 'TicketsController@inprogressticketsperdepartment']);
    Route::get('/tickets/closedperdepartment/{$department}', ['as' => 'dept.closed.ticket', 'uses' => 'TicketsController@closedticketsperdepartment']);
    // append
});
