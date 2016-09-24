<?php

Route::get('/adminpanel', function () {
    $users[] = Auth::guard('staff')->user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    dd($users);
})->name('home');

