<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(['prefix' => 'relations', 'middleware' => ['web', 'auth']], function () {
  Route::get('/', function () {
    dd('This is the Relations module index page. Build something great!');
  });
});
