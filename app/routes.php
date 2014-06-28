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
    'as' => 'get-edit-user',
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
  Route::get('signout', array(
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

  /*
  | Add Vinyl
  */

  Route::get('search/vinyl', array(
    'as' => 'get-create-vinyl',
    'uses' => 'VinylsController@createVinyl'
  ));

  Route::post('search/vinyl', array(
    'as' => 'post-create-vinyl',
    'uses' => 'VinylsController@storeVinyl'
  ));

  /*
  | Discogs oAuth
  */

  Route::get('oauth/discogs', array(
    'as' => 'get-oAuthDiscogs',
    'uses' => 'VinylsController@oAuthDiscogs'
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
  Route::get('register', array(
    'as' => 'get-user-create',
    'uses' => 'UsersController@create'
  ));

  Route::post('register', array(
    'as' => 'post-user-create',
    'uses' => 'UsersController@store'
  ));

  Route::get('signin', array(
    'as' => 'get-signin',
    'uses' => 'UsersController@getSignin'
  ));

  Route::post('signin', array(
    'as' => 'post-signin',
    'uses' => 'UsersController@postSignin'
  ));

  Route::get('activate/{code}', array(
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

/*
| Collection
*/
Route::get('users/{id}/collection', array(
  'as' => 'get-collection',
  'uses' => 'VinylsController@showCollection'  
));

/*
| Single Vinyl
*/
Route::get('vinyls/{id}', array(
  'as' => 'get-vinyl',
  'uses' => 'VinylsController@showVinyl'  
));

