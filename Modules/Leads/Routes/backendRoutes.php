<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/leads'], function () {

    /**
     * LEADS
     */
    Route::resource('leads', 'LeadsController');

    Route::get('/', [
        'as' => 'leads.index',
        'uses' => 'LeadsController@index',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);

    Route::get('/data', 'LeadsController@anyData')->name('leads.data');
    Route::patch('/updateassign/{id}', 'LeadsController@updateAssign');
    Route::post('/notes/{id}', 'NotesController@store');
    Route::patch('/updatestatus/{id}', 'LeadsController@updateStatus');
    Route::patch('/updatefollowup/{id}', 'LeadsController@updateFollowup')->name('leads.followup');

    // append
});
