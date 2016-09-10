<?php

Route::get('/adminpanel', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    dd($users);
})->name('home');

