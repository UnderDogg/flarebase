<?php
use Illuminate\Support\Facades\Route;

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
/*Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);*/


Route::group(['middleware' => 'web'], function () {
    // Authentication Routes...
    Route::get('login', '\App\Http\Controllers\Auth\AuthController@showLoginForm');
    Route::post('login', '\App\Http\Controllers\Auth\AuthController@login');


    Route::get('stafflogin', '\App\Http\Controllers\StaffAuth\LoginController@showStaffLoginForm');
    Route::post('stafflogin', '\App\Http\Controllers\Auth\StaffController@postStaffLogin');

    Route::get('staff/logout', '\App\Http\Controllers\StaffAuth\LoginController@getLogout');

    Route::get('logout', 'App\Http\Controllers\Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'App\Http\Controllers\Auth\AuthController@showRegistrationForm');
    Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'App\Http\Controllers\Auth\PasswordController@showResetForm');
    Route::post('password/email', 'App\Http\Controllers\Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'App\Http\Controllers\Auth\PasswordController@reset');
});

/*Route::auth();*/

/*
  |------------------------------------------------------------------
  |Guest Routes
  |--------------------------------------------------------------------
  | Here defining Guest User's routes
  |
  |
 */
Route::group(['middleware' => 'web'], function () {


    Route::get('', ['as' => '/', 'uses' => 'WelcomepageController@index']);
    Route::get('guestindex', ['as' => '/', 'uses' => 'WelcomepageController@index']);
    Route::get('/', ['as' => '/', 'uses' => 'WelcomepageController@index']);
    Route::get('/', ['as' => 'home', 'uses' => 'WelcomepageController@index']); //guest layout


    // search
    Route::POST('tickets/search/', function () {
        $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
        $models = App\Model\Ticket\Tickets::where('ticket_number', '=', $keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
        $count = count($models);
        return Illuminate\Support\Facades\Redirect::back()->with('contents', $models)->with('counts', $count);
    });
    Route::any('getdata', function () {
        $term = Illuminate\Support\Str::lower(Input::get('term'));
        $data = Illuminate\Support\Facades\DB::table('tickets')->distinct()->select('ticket_number')->where('ticket_number', 'LIKE', $term . '%')->groupBy('ticket_number')->take(10)->get();
        foreach ($data as $v) {
            return [
                'value' => $v->ticket_number,
            ];
        }
    });


    Route::get('getform', ['as' => 'guest.getform', 'uses' => 'FormController@getForm']); /* get the form for create a ticket by guest user */
    Route::post('postform/{id}', 'FormController@postForm'); /* post the AJAX form for create a ticket by guest user */
    Route::post('postedform', 'FormController@postedForm'); /* post the form to store the value */
    Route::get('client/create-ticket', ['as' => 'form', 'uses' => 'FormController@getForm']); //getform
    Route::get('client/mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'GuestController@singleThread']); //detail ticket information
    Route::post('checkmyticket', 'GuestController@PostCheckTicket'); //ticket ckeck
    Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'GuestController@get_ticket_email']); //detail ticket information


    //===================================================================================
    Route::group(['middleware' => 'role.client', 'middleware' => 'client'], function () {
        Route::get('client/profile', ['as' => 'client.profile', 'uses' => 'GuestController@getProfile']); /*  User profile get  */
        Route::get('client/mytickets', ['as' => 'ticket2', 'uses' => 'GuestController@getMyticket']);
        Route::get('client/myticket/{id}', ['as' => 'ticket', 'uses' => 'GuestController@thread']); /* Get my tickets */
        Route::patch('client-profile-edit', 'GuestController@postProfile'); /* User Profile Post */
        Route::patch('client-profile-password', 'GuestController@postProfilePassword'); /*  Profile Password Post */
        Route::post('post/reply/{id}', ['as' => 'client.reply', 'uses' => 'ClientTicketController@reply']);
    });


    //====================================================================================
    Route::get('client/checkticket', 'ClientTicketController@getCheckTicket'); /* Check your Ticket */
    Route::get('client/myticket', ['as' => 'ticket', 'uses' => 'GuestController@getMyticket']); /* Get my tickets */
    Route::get('client/myticket/{id}', ['as' => 'ticket', 'uses' => 'GuestController@thread']); /* Get my tickets */
    Route::post('postcheck', 'GuestController@PostCheckTicket'); /* post Check Ticket */
    Route::get('postcheck', 'GuestController@PostCheckTicket');
    Route::post('post-ticket-reply/{id}', 'FormController@post_ticket_reply');
    /* 404 page */


    // Route::get('404', 'error\ErrorController@error404');
});

