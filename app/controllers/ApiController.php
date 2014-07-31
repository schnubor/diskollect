<?php

class ApiController extends BaseController {

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

}
