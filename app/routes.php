<?php

Route::model('user', 'User');

// LOGGED GROUP
// WHY: These are the only routes they can visit, no access to /login or /register if they're logged in
Route::group(array('before' => 'auth'), function() {
        Route::get('/', array(
            "as" => "home",
            "uses" => "UserController@home"
         ));
        
        Route::get('/logout', array(
            "as" => "logout",
            "uses" => "UserController@getLogout"
        ));
        
        Route::get('/user/{id}', array(
            'as' => 'showProfile',
            'uses' => 'ProfileController@show'
        ))->where("id", "\d+");
        
        Route::get('/user/editInfo', array(
            'as' => 'getEditInfo',
            'uses' => 'ProfileController@getEditInfo'
        ));
        
        Route::get('/user/{id}/addFriend', array(
            'as' => 'addFriend',
            'uses' => 'ProfileController@addFriend'
        ));
        
        Route::get('/user/{id}/deleteFriend', array(
            'as' => 'deleteFriend',
            'uses' => 'ProfileController@deleteFriend'
        ));
        
        Route::get('/user/friendRequests', array(
            'as' => 'getFriendRequests',
            'uses' => 'ProfileController@getFriendRequests'
        ));
        
        Route::get('/user/{id}/cancelRequest', array(
            'as' => 'cancelRequest',
            'uses' => 'ProfileController@cancelRequest'
        ));
        
        Route::get('/search', array(
            'as' => 'searchPage',
            'uses' => 'ProfileController@search'
        ));
         
        // CSRF routes, WHY: when entering sensitive info
        Route::group(array('before' => 'csrf'), function() {
            Route::post('/changeProfilePicture', array(
                'as' => 'changeProfilePicture',
                'uses' => 'ProfileController@changeProfilePicture'
            ));
            
            Route::post('/user/editInfo', array(
                'as' => 'postEditInfo',
                'uses' => 'ProfileController@postEditInfo'
            ));
            
            Route::post('/user/friendRequests', array(
            'as' => 'postFriendRequests',
            'uses' => 'ProfileController@postFriendRequests'
            ));
        });
        
        // experimantal
        Route::get('/status', function(){
            return View::make('status')->with('title', 'Status experimental page');
        });
        Route::get('/status2', function(){
            return View::make('status2')->with('title', 'Status experimental page');
        });
         Route::get('/status3', function(){
            return View::make('status3')->with('title', 'Status experimental page');
        });
        Route::get('/poststatus', function(){
            return View::make('postStatus')->with('title', 'Status experimental page');
        });
        Route::get('/ajax', function(){
            return View::make('ajax')->with('title', 'Ajax test');
        });
        
        Route::post('/ajax', array(
            'as' => 'postAjaxStatus',
            'uses' => 'PostsController@postAjaxStatus'
        ));
        
        Route::post('/newComment', array(
            'as' => 'newComment',
            'uses' => 'PostsController@ajaxComment'
        ));
        
        Route::post('/postToWall', array(
            'as' => 'postToWall',
            'uses' => 'PostsController@postToWall'
        ));
        Route::post('/likePost', array(
            'as' => 'likePost',
            'uses' => 'PostsController@likePost'
        ));
        Route::post('/getUsersThatLiked', array(
            'as' => 'getUsersThatLiked',
            'uses' => 'PostsController@getUsersThatLiked'
        ));
});

/*
/	Nelogiana grupa
*/
Route::group(array('before' => 'guest'), function() {

	/*
	/	csrf zastita
	*/

	Route::group(array('before' => 'csrf'), function() {

		Route::post('/register', array(
			"as" => "register",
			"uses" => "UserController@postRegister"
		));
                
                Route::post('/login', array(
			"as" => "postLogin",
			"uses" => "UserController@postLogin"
		));
	});

	Route::get('/register', array(
		"as" => "register",
		"uses" => "UserController@getRegister"
	));

	Route::get('/login', array(
		"as" => "getLogin",
		"uses" => "UserController@getLogin"
	));
        
        Route::get('/user/activate/{code}', array(
            'as' => 'activateAccount',
            'uses' => 'UserController@activateAccount'
        ));
});