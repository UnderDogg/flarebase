<?php

Route::get('/customer/home', function () {
    dd(Auth::guard('customer')->user());
});

