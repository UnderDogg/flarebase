<?php
/*
 *  NameSpace and MiddleWare (//'middleware' => 'staff', 'namespace' => '\Modules\Core\Http\Controllers') already applied in app / RouteServiceprovicer
 **/

Route::group(['prefix' => '/staffpanel'], function () {
    Route::get('/', ['as' => 'staffdashboard', 'uses' => 'DashBoardController@staffdashboard']);
    Route::get('dashboard', 'DashBoardController@staffdashboard')->name('staffpaneldashboard');
    // append
});

Route::get('/leads', [
    'as' => 'leads.index',
    'uses' => 'LeadsController@index',
    //'middleware' => 'can:mailboxes.mailboxes.index'
]);