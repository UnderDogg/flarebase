<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/documents'], function () {

    Route::resource('documents', 'DocumentsController');
    /**
     * IMPORT AND EXPORT
     */
    Route::get('/import', 'DocumentsController@import');

    // append
});
