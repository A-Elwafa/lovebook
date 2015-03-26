<?php

class UserController extends BaseController{

	public function home()
	{
            $title = "Lovebook - Front page";
            //get a collection of users friends
            $friends = Auth::user()->friends->add(Auth::user());
            
            $feedPosts = new Collection;
            if($friends != NULL){
                foreach($friends as $friend){
                    foreach($friend->myPosts() as $post){
                        $feedPosts->add($post);
                    }
                }
            }
            $feedPosts->sortBy(function($Post){
                return $Post->created_at;
            },SORT_REGULAR, true);
            
            
            //var_dump($feedPosts);
            return View::make("home")->with(array(
                'title' => $title,
                'statuses' => $feedPosts,
            ));
	}

	public function getRegister(){
            $title = 'Lovebook - Register';
            return View::make('guest.register')->with('title', $title);
	}

	public function postRegister(){
	    $input = Input::all();
            $validator = Validator::make($input, 
                array(
                    'email' => 'required|max:50|email|unique:users',
                    'first_name' => 'required|between:2,25',
                    'middle_name' => 'between:2,25',
                    'last_name' => 'required|min:2|max:50',
                    'password' => 'required|min:6|alpha_dash',
                    'password_again' => 'required|same:password'
                )
            );
            
            if($validator->fails())
            {
                return Redirect::route('register')
                        ->withErrors($validator)
                        ->withInput();
            }
            else
            {
                $code = str_random(40);
                $user = User::create(array(
                    'email' => $input['email'],
                    'first_name' => $input['first_name'],
                    'middle_name' => $input['middle_name'],
                    'last_name' => $input['last_name'],
                    'password' => Hash::make($input['password']),
                    'code' => $code,
                    'activated' => 0,
                ));
                
                $profile = new Profile;
                    $profile->user_id = $user->id;
                    $profile->save();
                    
                if($user){
                    Mail::send('emails.auth.activate', array(
                        'link' => URL::route('activateAccount', $code),
                        'name' => $user->full_name,                        
                    ), function($message) use ($user){
                        $message->to($user->email, $user->full_name)->subject('Lovebook - Activate your account');
                    });
                    
                    return Redirect::route('getLogin')
                            ->with('global', 'Just one more step, we have sent you an email with activation link.');
                }
            }
	}

	public function getLogin(){
            $title = 'Lovebook - Log in';
            return View::make('guest.login')->with('title', $title);
	}

	public function postLogin(){
            $input = Input::all();
            
            $validator = Validator::make($input, array(
                'email' => 'required|email',
                'password' => 'required'
            ));
            
            if($validator->fails()){
                // Vrati na login
                
                return Redirect::route('getLogin')
                        ->withErrors($validator)
                        ->withInput();
            }
            else{
                // provjeri remember checkbox
                $remember = (Input::has('remember')) ? true : false;
                
                // Pokusaj logirati
                $auth = Auth::attempt(array(
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'activated' => '1',
                ), $remember);
                
                if($auth){
                    // preusmjeri na stranicu na koju je korisnik htio otici
                    return Redirect::route('home');
                } else{
                    return Redirect::route("getLogin")
                            ->with('global', 'Wrong login info or not registered or activated.');
                }
            }
	}
        
        public function getLogout(){
            Auth::logout();
            return Redirect::route('getLogin');
        }
        public function activateAccount($code){
            $user = User::where('code', '=', $code)->where('activated', '=', '0')->first();
            
            //if there is no user
            if($user == NULL){
                return Redirect::route('getLogin')
                        ->with('global', 'Error, we are sorry for inconvenience.');
            }
            //activate user
            $user->activated = 1;
            //remove activation code
            $user->code = NULL;
            $user->save();
            
            return Redirect::route('getLogin')
                    ->with('global', 'Your account has been activated, you can now log in.');
        }
}