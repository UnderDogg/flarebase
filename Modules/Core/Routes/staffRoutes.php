<?php
/*
 *  NameSpace and MiddleWare ('middleware' => 'staff', 'namespace' => '\Modules\Core\Http\Controllers') already applied in app / RouteServiceprovicer
 **/

Route::group(['prefix' => '/staff'], function () {
    Route::get('/profile', ['as' => 'staff.profile', 'uses' => 'StaffController@staffprofile']);
    // append
});

Route::get('/leads', [
    'as' => 'leads.index',
    'uses' => 'LeadsController@index',
    //'middleware' => 'can:mailboxes.mailboxes.index'
]);