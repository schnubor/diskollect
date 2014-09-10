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
    //$user = User::find(1);
    $user = User::where('username', '=', $username)->first();
    //$count = $user->vinyls->count();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'user' => $user->toArray(),
      'vinyls' => $user->vinyls->toArray()
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
    //$user = User::find(1);
    $vinyl = Vinyl::where('id', '=', $id)->first();
    //$count = $user->vinyls->count();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'vinyl' => $vinyl->toArray(),
      'tracks' => $vinyl->tracks->toArray()
    ));
  }

}
