<?php

/*
  |=============================================================
  |  View all the Routes
  |=============================================================
 */
Route::get('/aaa', function () {
    $routeCollection = Route::getRoutes();
    echo "<table style='width:100%'>";
    echo '<tr>';
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Url</h4></td>";
    echo "<td width='80%'><h4>Corresponding Action</h4></td>";
    echo '</tr>';
    foreach ($routeCollection as $value) {
        echo '<tr>';
        echo '<td>' . $value->getMethods()[0] . '</td>';
        echo '<td>' . $value->getName() . '</td>';
        echo '<td>' . $value->getPath() . '</td>';
        echo '<td>' . $value->getActionName() . '</td>';
        echo '</tr>';
    }
    echo '</table>';
});


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

    Route::resource('departments', 'DepartmentsController');
    Route::get('/', ['as' => 'admindepartments', 'uses' => 'DepartmentsController@index']);

    Route::resource('integrations', 'IntegrationsController');
    /* SLACK */
    Route::get('integration/slack', 'IntegrationsController@slack');

    Route::resource('company', 'CompanyController');
    Route::get('/', ['as' => 'admincompany', 'uses' => 'CompanyController@index']);

    Route::resource('system', 'SystemController');
    Route::get('/', ['as' => 'adminsystem', 'uses' => 'SystemController@index']);

    Route::resource('language', 'LanguageController');
    Route::get('/', ['as' => 'adminlanguage', 'uses' => 'LanguageController@index']);


    Route::resource('staff', 'StaffController');
    Route::get('staff', ['as' => 'adminstaff', 'uses' => 'StaffController@index']);


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

