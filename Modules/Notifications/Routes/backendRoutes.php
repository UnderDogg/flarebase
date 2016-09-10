<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/notifications'], function () {

    Route::resource('notifications', 'NotificationsController');
    /**
     * NOTIFICATIONS
     */
    Route::get('/getall', ['as' => 'notifications.get', 'uses' => 'NotificationsController@gotAll']);
    Route::post('/markread', 'NotificationsController@markRead');
    Route::get('/markall', 'NotificationsController@markAll');
    // append
});
