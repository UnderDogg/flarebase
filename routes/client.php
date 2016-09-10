<?php

Route::get('/guestindex', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('client')->user();

    dd($users);
})->name('home');

