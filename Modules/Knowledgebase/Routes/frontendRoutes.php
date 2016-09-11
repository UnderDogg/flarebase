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

Route::group(['prefix' => 'knowledgebase'], function () {
// Route::get('/',['as'=>'home' , 'uses'=> 'UserController@home'] );
    Route::resource('user', 'UserController');



    /* post the comment from show page */
    Route::post('postcomment/{slug}', ['as' => 'postcomment', 'uses' => 'UserController@postComment']);
    /* get the article list */
    Route::get('article-list', ['as' => 'article-list', 'uses' => 'UserController@getArticle']);
// /* get search values */
    Route::get('search', ['as' => 'search', 'uses' => 'UserController@search']);
    /* get the selected article */
    Route::get('show/{slug}', ['as' => 'show', 'uses' => 'UserController@show']);
    Route::get('category-list', ['as' => 'category-list', 'uses' => 'UserController@getCategoryList']);
    /* get the categories with article */
    Route::get('category-list/{id}', ['as' => 'categorylist', 'uses' => 'UserController@getCategory']);
    /* get the home page */
    Route::get('knowledgebase', ['as' => 'home', 'uses' => 'UserController@home']);
    /* get the faq value to user */
// $router->get('faq',['as'=>'faq' , 'uses'=>'UserController@Faq'] );
    /* get the cantact page to user */
    Route::get('contact', ['as' => 'contact', 'uses' => 'UserController@contact']);
    /* post the cantact page to controller */
    Route::post('post-contact', ['as' => 'post-contact', 'uses' => 'UserController@postContact']);
//to get the value for page content
    Route::get('pages/{name}', ['as' => 'pages', 'uses' => 'UserController@getPage']);
});
