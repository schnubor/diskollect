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
| Authenticated group
*/
Route::group(array('before' => 'auth'), function(){

  /*
  | GET change password form
  */
  Route::get('users/change-password', array(
    'as' => 'get-change-password',
    'uses' => 'UsersController@getChangePassword'
  ));

  /*
  | POST change password
  */
  Route::post('users/change-password', array(
    'as' => 'post-change-password',
    'uses' => 'UsersController@postChangePassword'
  ));

  /*
  | GET edit user form
  */
  Route::get('users/edit', array(
    'as' => 'edit-userprofile',
    'uses' => 'UsersController@edit'
  ));

  /*
  | UPDATE edit user
  */
  Route::any('users/update', array(
    'as' => 'update-user',
    'uses' => 'UsersController@update'
  ));

  /*
  | Sign out
  */
  Route::get('users/signout', array(
    'as' => 'get-signout',
    'uses' => 'UsersController@getSignout'
  ));

  /*
  | Search
  */
  Route::get('search', array(
    'as' => 'get-search',
    'uses' => 'VinylsController@getSearch'
  ));

  Route::post('search', array(
    'as' => 'post-search',
    'uses' => 'VinylsController@postSearch'
  ));

});

/*
| Unauthenticated group
*/
Route::group(array('before' => 'guest'), function(){

  /*
  | CSRF protection
  */
  Route::when('*', 'csrf', array('post', 'put', 'delete'));

  /*
  | User routes (order is important!)
  */
  Route::get('users/signin', array(
    'as' => 'get-signin',
    'uses' => 'UsersController@getSignin'
  ));

  Route::post('users/signin', array(
    'as' => 'post-signin',
    'uses' => 'UsersController@postSignin'
  ));

  Route::get('users/activate/{code}', array(
    'as' => 'account-activate',
    'uses' => 'UsersController@activate'
  ));

});

/*
| Everyone
*/

Route::get('users', array(
  'as' => 'get-all-users',
  'uses' => 'UsersController@index'
));

Route::get('users/{id}', array(
  'as' => 'get-user',
  'uses' => 'UsersController@show'
));

