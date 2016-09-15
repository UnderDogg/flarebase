<?php
use Illuminate\Routing\Router;


Route::get('/tickettypesdata', ['as' => 'tickettypes.data', 'uses' => 'TicketTypesController@anyData']);
Route::get('/ticketprioritiessdata', ['as' => 'ticketpriorities.data', 'uses' => 'TicketPrioritiesController@anyData']);





Route::group(['prefix' => '/ticketspanel'], function () {
    Route::resource('tickets', 'TicketsController');
    Route::get('/', ['as' => 'ticketspanel', 'uses' => 'DashBoardController@ticketsdashboard']);


    Route::resource('ticketsettings', 'TicketSettingsController');
    Route::resource('tickettypes', 'TicketTypesController');
    Route::resource('ticketstatuses', 'TicketStatusesController');
    Route::resource('ticketpriorities', 'TicketPrioritiesController');
    Route::resource('tickethelptopics', 'TicketHelpTopicsController');
    Route::resource('ticketlinktypes', 'TicketLinkTypesController');
    Route::resource('slaplans', 'SlaPlansController');
    Route::resource('autocloserules', 'AutoCloseRulesController');
    Route::resource('batchactions', 'BatchActionsController');
    Route::resource('ticketworkflows', 'WorkFlowsController');

    Route::get('/escalatetickets', ['as' => 'escalatetickets', 'uses' => 'TicketsEscalations@escalatetickets']);
    // append
});




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
