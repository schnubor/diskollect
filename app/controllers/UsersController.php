<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::get();
		return View::make('users.index')
			->with('users', $users);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), array(
			'email' => 'required|max:50|email|unique:users',
			'username' => 'required|max:20|min:3|unique:users',
			'password' => 'required|min:6',
			'password_again' => 'required|same:password'
		));

		if($validator->fails()){
			return Redirect::to('users/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else{
			// Create account

			$email 		= Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');

			// Activation Code
			$code 		= str_random(60);

			$user = User::create(array(
				'email' => $email,
				'username' => $username,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0
			));

			if($user){
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user){
					$message->to($user->email, $user->username)->subject('Diskollect Account Activation');
				});

				return Redirect::to('/')
					->with('success-alert', 'Your account hast been created! We have sent you an email.');
			}

		}
	}

	/**
	 * Active User Account
	 * GET /users/activate
	 *
	 * @return Response
	 */

	public function activate($code)
	{
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if($user->count()){
			$user = $user->first();

			// Update user to active state

			$user->active = 1;
			$user->code = '';

			if($user->save()){
				return Redirect::to('/')
					->with('success-alert', 'Success! Your account has been activated and you may now sign in.');
			}
		}

		return Redirect::to('/')
			->with('danger-alert', 'We could not activate your account. Please try again later.');

	}

	/**
	 * Sign-in Form
	 * GET /users/signin
	 *
	 * @return Response
	 */

	public function getSignin()
	{
		return View::make('users.signin');
	}

	/**
	 * Signin Form Submit
	 * POST /users/signin
	 *
	 * @return Response
	 */

	public function postSignin()
	{
		$validator = Validator::make(Input::all(), array(
			'email' => 'required|email',
			'password' => 'required'
		));

		if($validator->fails()){
			return Redirect::route('get-signin')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else{

			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'email' => input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
			), $remember);

			if($auth){
				//Redirect to intended page
				return Redirect::intended('/')
					->with('success-alert', 'Welcome! You have been signed in.');
			}
			else{
				return Redirect::to('/users/signin')
					->with('danger-alert', 'Oops! Email/Password incorrect or your account is not activated.');
			}

		}

		return Redirect::to('/users/signin')
			->with('danger-alert', 'Oops! There was a problem signing you in.');
	}

	/**
	 * Sign-out
	 * GET /users/signout
	 *
	 * @return Response
	 */

	public function getSignout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	/**
	 * Change password
	 * GET /users/change-password
	 *
	 * @return Response
	 */

	public function getChangePassword()
	{
		return View::make('users/password');
	}

	public function postChangePassword()
	{
		$validator = Validator::make(Input::all(), array(
			'old_password' 		=> 'required',
			'password' 				=> 'required|min:6',
			'password_again' 	=> 'required|same:password'
		));

		if($validator->fails()){
			return Redirect::to('users/change-password')
				->withErrors($validator);
		}
		else{
			$user 				= User::find(Auth::user()->id);

			$old_password = Input::get('old_password');
			$password 		= Input::get('password');

			if(Hash::check($old_password, $user->getAuthPassword())){
				$user->password = Hash::make($password);

				if($user->save()){
					return Redirect::to('/')
						->with('success-alert', 'Congratulations! You successfully changed your password');
				}
			}
			else{
				// old password incorrect
				return Redirect::to('users/change-password')
					->with('danger-alert', 'Old password provided is incorrect.');
			}
		}

		return Redirect::to('users/change-password')
			->with('danger-alert', 'Your password could not be changed. Unknown Error.');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		$vinyls = $user->vinyls;

		return View::make('users.show')
			->with('user', $user)
			->with('vinyls', $vinyls);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		$user = User::find(Auth::user()->id);
		return View::make('users.edit')
			->with('user', $user);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$validator = Validator::make(Input::all(), array(
			'name' => 'max:50',
			'location' => 'max:50',
			'website' => 'url|max:50',
			'description' => 'max:140',
			'profilepic' => 'image|max:2000'
		));

		if($validator->fails()){
			return Redirect::to('users/edit')
				->withInput()
				->withErrors($validator);
		}
		else{
			$file = Input::file('profilepic');
			$path = public_path() . '/profile_images/';

			if($file){
				$filename = 'user_' . Auth::user()->id . '_' . $file->getClientOriginalName();
				$file->move($path,$filename);
				$user->image = $path . $filename;
			}

			$user = User::find(Auth::user()->id);
			$user->name = Input::get('name');
			$user->location = Input::get('location');
			$user->website = Input::get('website');
			$user->description = Input::get('description');

			if($user->save()){
				return Redirect::to('/users/'.Auth::user()->id)
					->with('success-alert', 'Success! Profile updated.');
			}

		}

		return Redirect::to('/users/'.Auth::user()->id)
			->with('danger-alert', 'Unknown Error! Could not update profile.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}