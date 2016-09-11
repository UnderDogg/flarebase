<?php
Route::group(['prefix' => '/adminpanel'], function () {
    Route::resource('adminpanel', 'DashBoardController');
    Route::get('', 'DashBoardController@index')->name('dashboard');
    // append
});

