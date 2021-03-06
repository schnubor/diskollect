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
		$users = User::paginate(20);
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
			'password_again' => 'required|same:password',
			'currency' => 'required'
		));

		if($validator->fails()){
			return Redirect::route('get-user-create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else{
			// Create account
			$email 		= Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');
			$currency = Input::get('currency');

			// Activation Code
			$code 		= str_random(60);

			$user = User::create(array(
				'email' => $email,
				'username' => e($username),
				'image' => e(USER_PH_PATH),
				'currency' => $currency,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0
			));

			if($user){
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user){
					$message->to($user->email, $user->username)->subject('Diskollect Account Activation');
				});

				return Redirect::route('get-signin')
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
				return Redirect::route('get-signin')
					->with('success-alert', 'Success! Your account has been activated and you may now sign in.');
			}
		}

		return Redirect::route('get-user-create')
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
			'user-email' => 'required',
			'password' => 'required'
		));

		if($validator->fails()){
			return Redirect::route('get-signin')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else{

			$remember = (Input::has('remember')) ? true : false;
			$field = filter_var(input::get('user-email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

			$auth = Auth::attempt(array(
				$field => input::get('user-email'),
				'password' => Input::get('password'),
				'active' => 1
			), $remember);

			if($auth){
				//Redirect to intended page
				return Redirect::intended('/');
			}
			else{
				return Redirect::to('/signin')
					->with('login-alert', 'Wrong email or password.');
			}

		}

		return Redirect::to('/signin')
			->with('login-alert', 'There was a problem signing you in.');
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
	 * Recover Account / Password
	 * GET /forgot-password
	 *
	 * @return Response
	 */

	public function getForgotPassword(){
		return View::make('users.recover');
	}

	/**
	 * Recover Account / Password
	 * GET /recover/{id}
	 *
	 * @return Response
	 */

	public function getRecover($code){
		$user =  User::where('code', '=', $code)
							->where('password_temp', '!=', '');

		if($user->count()){
			$user = $user->first();

			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';

			if($user->save()){
				return Redirect::route('get-signin')
					->with('success-alert', 'Success! You may now use your new password that we sent to you by email.');
			}
		}

		return Redirect::route('get-signin')
			->with('danger-alert', 'Unknown error! Something went wrong while setting your new password.');
	}

	/**
	 * Recover Account / Password
	 * POST /forgot-possword
	 *
	 * @return Response
	 */

	public function postForgotPassword(){
		$validator = Validator::make(Input::all(), array(
				'email' =>'required|email'
		));

		if($validator->fails()){
			return Redirect::route('get-forgot-password')
				->withInput()
				->withErrors($validator);
		}
		else{
			$user = User::where('email', '=', Input::get('email'));

			if($user->count()){
				$user = $user->first();

				$code = str_random(60);
				$password = str_random(10);

				$user->code = $code;
				$user->password_temp = Hash::make($password);

				if($user->save()){
					Mail::send('emails.auth.recover', array('link' => URL::route('get-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user){
						$message->to($user->email, $user->username)->subject('Your new password');
					});

					return Redirect::route('get-signin')
						->with('success-alert', 'We have sent you an email containing your new password.');
				}
			}
		}

		return Redirect::route('get-forgot-password')
			->with('danger-alert', 'Unknown error! Could not reset your password.');
	}

	/**
	 * Display the specified user.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$lvlFactor = 10; // bigger = slower leveling
		$rank = ['1' => 'Beginner', '2' => 'Rookie', '3' => 'Ambitious', '4' => 'Advanced'];

		// Ranks
		$rank = ["1" => "Beginner", "2" => "Rookie", "3" => "Advanced Rookie", "4" => "Enthusiast", "5" => "Lover", "6" => "Expert", "7" => "Collector", "8" => "Master Collector", "9" => "Nerd", "10" => "Vinyl Guru"];

		$user = User::find($id);
		$vinyls = $user->vinyls();
		
		// Prices
		$prices = array(
			'price_sum' => number_format(round($vinyls->sum('price'),2),2),
			'price_avg' => number_format(round($vinyls->avg('price'),2),2),
			'price_max' => number_format(round($vinyls->max('price'),2),2)
		);

		// Level
		$level = floor(($lvlFactor+sqrt($lvlFactor*$lvlFactor+4*$lvlFactor*$vinyls->count()))/(2*$lvlFactor));

		$currentLvlVinyls = $lvlFactor*$level*$level-$lvlFactor*$level;
		$nextLvlVinyls = $lvlFactor*($level+1)*($level+1)-$lvlFactor*($level+1);

		$progress = floor(($vinyls->count()-$currentLvlVinyls) / (($nextLvlVinyls - $currentLvlVinyls) / 100));

		// Fav artist
		$favArtist = DB::table('vinyls')
														->select(DB::raw('count(*) as artist_count, artist'))
														->where('user_id', '=', $id)
														->groupBy('artist')
														->orderBy('artist_count','DESC')
														->first();

		// Fav Label
		$favLabel = DB::table('vinyls')
														->select(DB::raw('count(*) as label_count, label'))
														->where('user_id', '=', $id)
														->groupBy('label')
														->orderBy('label_count','DESC')
														->first();

		// Most valuable vinyl
		$valueVinylQuery = DB::table('vinyls')
														->select(DB::raw('id, max(`price`)'))
														->where('user_id', '=', $id)
														->groupBy('id')
														->orderBy('price','DESC')
														->first();

		if(isset($valueVinylQuery)){
			$valueVinyl = $vinyls->find($valueVinylQuery->id);
		}
		else{
			$valueVinyl = NULL;
		}


		//dd($valueVinyl);

		return View::make('users.show')
			->with('user', $user)
			->with('vinyls', $vinyls)
			->with('level', $level)
			->with('rank', $rank[$level])
			->with('progress', $progress)
			->with('nextLvlVinyls', $nextLvlVinyls)
			->with('rank', $rank[$level])
			->with('favArtist', $favArtist)
			->with('favLabel', $favLabel)
			->with('valueVinyl', $valueVinyl)
			->with('prices', $prices);
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
		$user = User::find(Auth::user()->id);

		$validator = Validator::make(Input::all(), array(
			'name' 				=> 'max:50',
			'location' 		=> 'max:50',
			'website' 		=> 'url|max:50',
			'description' => 'max:140',
			'profilepic' 	=> 'image|max:2000',
			'currency'		=> 'required'
		));

		if($validator->fails()){
			return Redirect::to('users/edit')
				->withInput()
				->withErrors($validator);
		}
		else{
			$file = Input::file('profilepic');
			$path = public_path() . '/images/users';

			if($file){
				$filename = 'user_' . Auth::user()->id . '_' . $file->getClientOriginalName();
				$file->move($path,$filename);
				$user->image = '/images/users/' . $filename;
			}

			$user->name = Input::get('name');
			$user->location = Input::get('location');
			$user->website = Input::get('website');
			$user->description = Input::get('description');
			$user->currency = Input::get('currency');

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
