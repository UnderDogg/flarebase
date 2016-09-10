<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/mailpanel'], function () {
    Route::resource('mailboxes', 'MailboxesController');
    Route::get('/', [
        'as' => 'admin.mailboxes.mailpanel.index',
        'uses' => 'MailboxesController@mailpanel',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);
    /** @var Router $router */
    Route::group(['prefix' => '/mailboxes'], function () {
        Route::resource('mailboxes', 'MailboxesController');
        Route::get('/', [
            'as' => 'admin.mailboxes.mailboxes.index',
            'uses' => 'MailboxesController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
        Route::get('data', 'MailboxesController@anyData')->name('mailboxes.data');
        Route::get('/create', [
            'as' => 'admin.mailboxes.mailbox.create',
            'uses' => 'MailboxesController@create',
            //'middleware' => 'can:mailboxes.mailboxes.create'
        ]);
        Route::post('/', [
            'as' => 'admin.mailboxes.mailbox.store',
            'uses' => 'MailboxesController@store',
            //'middleware' => 'can:mailboxes.mailboxes.store'
        ]);
        Route::get('/{mailbox}/edit', [
            'as' => 'admin.mailboxes.mailbox.edit',
            'uses' => 'MailboxesController@edit',
            //'middleware' => 'can:mailboxes.mailboxes.edit'
        ]);
        Route::put('/{mailbox}', [
            'as' => 'admin.mailboxes.mailbox.update',
            'uses' => 'MailboxesController@update',
            //'middleware' => 'can:mailboxes.mailboxes.update'
        ]);
        Route::delete('/{mailbox}', [
            'as' => 'admin.mailboxes.mailbox.destroy',
            'uses' => 'MailboxesController@destroy',
            //'middleware' => 'can:mailboxes.mailboxes.destroy'
        ]);
        // append
    });


    // append
});



