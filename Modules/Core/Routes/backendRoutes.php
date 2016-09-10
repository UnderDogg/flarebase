<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//'middleware' => 'staff'
Route::group(['prefix' => '/adminpanel'], function () {
    /**
     * MAIN
     */
    Route::get('/', ['as' => 'admindashboard', 'uses' => 'DashBoardController@admindashboard']);
    Route::get('dashboard', 'DashBoardController@admindashboard')->name('adminpaneldashboard');
    Route::get('getdiagno', 'TemplateController@formDiagno'); // for getting form for diagnostic

    /**
     * DEPARTMENTS
     */
    Route::resource('departments', 'DepartmentsController');
    /**
     * INTEGRATIONS
     */
    Route::resource('integrations', 'IntegrationsController');
    /* SLACK */
    Route::get('integration/slack', 'IntegrationsController@slack');

    /**
     * USERS which means possible logins of the clients
     */
    Route::resource('users', 'UsersController');
    Route::get('users/', 'UsersController@index')->name('users.index');
});


Route::group(['prefix' => '/staffpanel'], function () {
    Route::get('/', ['as' => 'staffdashboard', 'uses' => 'DashBoardController@staffdashboard']);
    Route::get('dashboard', 'DashBoardController@staffdashboard')->name('staffpaneldashboard');
    // append
});

