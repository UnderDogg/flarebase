<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/kb'], function () {

  Route::resource('knowledgebase', 'KnowledgeBaseController');

  // append
});
