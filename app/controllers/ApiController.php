<?php

class ApiController extends BaseController {

  /**
   * Return Welcome Page / API Introduction
   * GET developer
   *
   * @return View
   */
  public function intro(){
    return View::make('api.intro');
  }

  /**
   * Return User info as JSON
   * GET api/user/{username}
   *
   * @return Response
   */
  public function deliverUser($username)
  {
    $user = User::where('username', '=', $username)->first();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'user' => $user->toArray()
    ));
  }

  /**
   * Return User info as JSON
   * GET api/user/{username}
   *
   * @return Response
   */
  public function deliverUserById($id)
  {
    $user = User::where('id', '=', $id)->first();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'user' => $user->toArray()
    ));
  }

  /**
   * Return User info as JSON
   * GET api/collection/{user_id}
   *
   * @return Response
   */
  public function deliverCollection($user_id)
  {
    $user = User::where('id', '=', $user_id)->first();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'collection' => $user->vinyls->toArray()
    ));
  }

  /**
   * Return Vinyl info as JSON
   * GET api/vinyl/{id}
   *
   * @return Response
   */
  public function deliverVinyl($id)
  {
    $vinyl = Vinyl::where('id', '=', $id)->first();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'vinyl' => $vinyl->toArray(),
      'tracks' => $vinyl->tracks->toArray()
    ));
  }

  /**
   * Return Vinyl info as JSON
   * GET api/track/{id}
   *
   * @return Response
   */
  public function deliverTrack($id)
  {
    $track = Track::where('id', '=', $id)->first();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'track' => $track->toArray(),
    ));
  }

}
