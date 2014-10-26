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

  Route::get('vinyl/create', array(
    'as' => 'get-create-vinyl',
    'uses' => 'VinylsController@createVinyl'
  ));

  Route::get('search/vinyl', array(
    'as' => 'get-create-vinyl-search',
    'uses' => 'VinylsController@createVinyl'
  ));

  Route::post('search/vinyl', array(
    'as' => 'post-create-vinyl',
    'uses' => 'VinylsController@storeVinyl'
  ));

  /*
  | Edit Vinyl
  */

  Route::get('vinyl/{id}/edit', array(
    'as' => 'get-edit-vinyl',
    'uses' => 'VinylsController@editVinyl'
  ));

  Route::any('vinyl/{id}/update', array(
    'as' => 'update-vinyl',
    'uses' => 'VinylsController@updateVinyl'
  ));

  /*
  | Delete Vinyl
  */
  Route::delete('vinyl/{id}', array(
    'as' => 'delete-vinyl',
    'uses' => 'VinylsController@deleteVinyl'
  ));

  /*
  | Delete Track
  */
  Route::delete('track/{id}', array(
    'as' => 'delete-track',
    'uses' => 'TracksController@destroy'
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
  | User routes
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

  Route::get('forgot-password', array(
    'as' => 'get-forgot-password',
    'uses' => 'UsersController@getForgotPassword'
  ));

  Route::post('forgot-password', array(
    'as' => 'post-forgot-password',
    'uses' => 'UsersController@postForgotPassword'
  ));

  Route::get('recover/{code}', array(
    'as' => 'get-recover',
    'uses' => 'UsersController@getRecover'
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
| Show Collection
*/
Route::get('users/{id}/collection/{view?}/{sort?}', array(
  'as' => 'get-collection',
  'uses' => 'VinylsController@showCollection'
));

/*
| Show Single Vinyl
*/
Route::get('vinyls/{id}', array(
  'as' => 'get-vinyl',
  'uses' => 'VinylsController@showVinyl'
));

/*
| API
*/

Route::get('developer', array(
  'as' => 'api-get-intro',
  'uses' => 'ApiController@intro'
));

Route::get('api/user/{username}', array(
  'as' => 'api-get-user',
  'uses' => 'ApiController@deliverUser'
));

Route::get('api/user_id/{id}', array(
  'as' => 'api-get-user-by-id',
  'uses' => 'ApiController@deliverUserById'
));

Route::get('api/collection/{user_id}', array(
  'as' => 'api-get-collection',
  'uses' => 'ApiController@deliverCollection'
));

Route::get('api/vinyl/{id}', array(
  'as' => 'api-get-vinyl',
  'uses' => 'ApiController@deliverVinyl'
));

Route::get('api/track/{id}', array(
  'as' => 'api-get-track',
  'uses' => 'ApiController@deliverTrack'
));

/*
| Pages
*/

Route::get('imprint', array(
  'as' => 'get-imprint', 
  function(){
    return View::make('pages.imprint');
  }));

Route::get('survey', array(
  'as' => 'get-survey', 
  function(){
    return View::make('pages.survey');
}));

Route::get('survey/de', array(
  'as' => 'get-survey-de', 
  function(){
    return View::make('pages.survey_de');
}));

Route::get('survey/en', array(
  'as' => 'get-survey-en', 
  function(){
    return View::make('pages.survey_en');
}));
