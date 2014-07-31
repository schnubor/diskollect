<?php

class ApiController extends BaseController {

  public function deliverUser($id)
  {
    $user = User::find(1);
    //$count = $user->vinyls->count();
 
    return Response::json(array(
      'error' => false,
      'message' => 200,
      'user' => $user->toArray(),
      'vinyls' => $user->vinyls->toArray()
    ));
  }

}
