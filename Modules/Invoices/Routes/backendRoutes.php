<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/invoices'], function () {
    /**
     * INVOICES
     */
    Route::resource('invoices', 'InvoicesController');
    Route::post('/updatepayment/{id}', 'InvoicesController@updatePayment')->name('invoice.payment.date');
    Route::post('/reopenpayment/{id}', 'InvoicesController@reopenPayment')->name('invoice.payment.reopen');
    Route::post('/sentinvoice/{id}', 'InvoicesController@updateSentStatus')->name('invoice.sent');
    Route::post('/reopensentinvoice/{id}', 'InvoicesController@updateSentReopen')->name('invoice.sent.reopen');
    Route::post('/newitem/{id}', 'InvoicesController@newItem')->name('invoice.new.item');

    // append
});
