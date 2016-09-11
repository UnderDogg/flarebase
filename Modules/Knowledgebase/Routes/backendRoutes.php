<?php
use Illuminate\Routing\Router;

Route::group(['prefix' => '/kbpanel'], function () {

    Route::resource('knowledgebase', 'KnowledgeBaseController');
    Route::resource('kbcategories', 'CategoriesController');
    Route::resource('kbarticles', 'ArticlesController');
    Route::resource('kbpages', 'PagesController');
    Route::resource('kbsettings', 'SettingsController');

    Route::get('category/delete/{id}', 'CategoriesController@destroy');
    /*  For the crud of article  */

    Route::get('article/delete/{id}', 'ArticlesController@destroy');
    /* get settings */
    Route::get('kb/settings', ['as' => 'settings', 'uses' => 'SettingsController@settings']);
    /* post settings */
    Route::patch('postsettings/{id}', 'SettingsController@postSettings');
//Route for administrator to access the comment
    Route::get('comment', ['as' => 'comment', 'uses' => 'SettingsController@comment']);
    /* Route to define the comment should Published */
    Route::get('published/{id}', ['as' => 'published', 'uses' => 'SettingsController@publish']);
    /* Route for deleting comments */
    Route::delete('deleted/{id}', ['as' => 'deleted', 'uses' => 'SettingsController@delete']);

    Route::get('get-pages', ['as' => 'api.page', 'uses' => 'PagesController@getData']);

    Route::get('page/delete/{id}', ['as' => 'pagedelete', 'uses' => 'PagesController@destroy']);
    Route::get('comment/delete/{id}', ['as' => 'commentdelete', 'uses' => 'SettingsController@delete']);
    Route::get('get-articles', ['as' => 'api.article', 'uses' => 'ArticlesController@getData']);
    Route::get('get-categories', ['as' => 'api.category', 'uses' => 'CategoriesController@getData']);
    Route::get('get-comment', ['as' => 'api.comment', 'uses' => 'SettingsController@getData']);
    Route::get('test', 'ArticlesController@test');
    Route::post('image', 'SettingsController@image');

    // append
});
