<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/relations'], function () {
  Route::resource('relations', 'RelationsController');

  //Auth::loginUsingId($fan->getAuthIdentifier());
  //echo "(backend) relations";

  //dd(Auth::guard());
  Route::get('/relations', [
    'as' => 'admin.relations.relations.index',
    'uses' => 'RelationsController@index',
    //'middleware' => 'can:relations.relations.index'
  ]);
//->name('relations.data')

  Route::get('/', [
    'as' => 'admin.relations.relations.index',
    'uses' => 'RelationsController@index',
    //'middleware' => 'can:relations.relations.index'
  ]);
  Route::get('data', 'RelationsController@anyData')->name('relations.data');
  Route::get('/create', [
    'as' => 'admin.relations.relation.create',
    'uses' => 'RelationsController@create',
    //'middleware' => 'can:relations.relations.create'
  ]);
  Route::post('/', [
    'as' => 'admin.relations.relation.store',
    'uses' => 'RelationsController@store',
    //'middleware' => 'can:relations.relations.store'
  ]);
  Route::get('/{relation}/edit', [
    'as' => 'admin.relations.relation.edit',
    'uses' => 'RelationsController@edit',
    //'middleware' => 'can:relations.relations.edit'
  ]);
  Route::put('/{relation}', [
    'as' => 'admin.relations.relation.update',
    'uses' => 'RelationsController@update',
    //'middleware' => 'can:relations.relations.update'
  ]);
  Route::delete('/{relation}', [
    'as' => 'admin.relations.relation.destroy',
    'uses' => 'RelationsController@destroy',
    //'middleware' => 'can:relations.relations.destroy'
  ]);
  // append
});
