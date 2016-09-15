<?php

Route::get('staffdata', [
    'as' => 'staff.data',
    'uses' => 'StaffController@anyData',
    //'middleware' => 'can:mailboxes.mailboxes.index'
]);

Route::get('teamsdata', [
    'as' => 'teams.data',
    'uses' => 'TeamsController@anyData',
    //'middleware' => 'can:mailboxes.mailboxes.index'
]);



Route::get('rolesdata', [
    'as' => 'roles.data',
    'uses' => 'RolesController@anyData',
    //'middleware' => 'can:mailboxes.mailboxes.index'
]);






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

    Route::resource('companies', 'CompaniesController');
    Route::get('/companies', ['as' => 'admincompany', 'uses' => 'CompanyController@index']);

    Route::resource('system', 'SystemController');
    Route::get('/adminsystem', ['as' => 'adminsystem', 'uses' => 'SystemController@index']);

    //Routes for showing language table and switching language
    Route::resource('languages', 'LanguagesController');
    Route::get('/languages', ['as' => 'adminlanguage', 'uses' => 'LanguagesController@index']);
    Route::get('get-languages', ['as' => 'getAllLanguages', 'uses' => 'LanguagesController@getLanguages']);
    Route::get('change-language/{lang}', ['as' => 'languages.switch', 'uses' => 'LanguagesController@switchLanguage']);
    //Route for download language template package
    Route::get('/download-template', ['as' => 'languages.download', 'uses' => 'LanguagesController@download']);
    //Routes for language file upload form-----------You may want to use csrf protection for these route--------------
    Route::post('language/add', 'LanguagesController@postForm');
    Route::get('language/add', ['as' => 'add-language', 'uses' => 'LanguagesController@getForm']);
    //Routes for  delete language package
    Route::get('delete-language/{lang}', ['as' => 'lang.delete', 'uses' => 'LanguagesController@deleteLanguage']);

    Route::resource('staff', 'StaffController');
    Route::get('/staff/manage', ['as' => 'adminstaff', 'uses' => 'StaffController@index']);
    Route::get('staff', ['as' => 'adminstaff', 'uses' => 'StaffController@index']);



    Route::resource('teams', 'TeamsController');
    Route::get('/teams/manage', ['as' => 'adminteams', 'uses' => 'TeamsController@index']);
    Route::get('teams', ['as' => 'adminteams', 'uses' => 'TeamsController@index']);


    Route::group(['prefix' => '/roles'], function () {
        Route::resource('roles', 'RolesController');
        Route::get('/manage', [
            'as' => 'adminroles',
            'uses' => 'RolesController@manage',
            //'middleware' => 'can:mailboxes.mailboxes.create'
        ]);
    });

    Route::resource('users', 'UsersController');
    Route::get('users/', 'UsersController@index')->name('users.index');
});







Route::group(['prefix' => '/staffpanel'], function () {
    Route::get('/', ['as' => 'staffdashboard', 'uses' => 'DashBoardController@staffdashboard']);
    Route::get('dashboard', 'DashBoardController@staffdashboard')->name('staffpaneldashboard');
    // append
});

