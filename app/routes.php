<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
  'as' => 'welcome',
  'uses' => 'HomeController@showWelcome'
));

/*
| Unauthenticated group
*/
Route::group(array('before' => 'guest'), function(){

  /*
  | CSRF protection
  */
  Route::when('*', 'csrf', array('post', 'put', 'delete'));

  Route::resource('users', 'UsersController');

  Route::get('users/activate/{code}', array(
    'as' => 'account-activate',
    'uses' => 'UsersController@activate'
  ));

  Route::resource('users.vinyls', 'VinylsController');

});
