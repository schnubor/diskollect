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
  Route::group(array('before' => 'csrf'), function(){

  });

  Route::resource('user', 'UserController');

});
