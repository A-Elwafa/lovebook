<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable = array('email', 'first_name', 'middle_name'
		, 'last_name', 'password', 'activated', 'code');

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
        
        // get full name
        public function getFullNameAttribute(){
            if($this->middle_name == (NULL || ''))
                return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
            else
                return $this->first_name .' '. $this->last_name;
        }
        
        
	public function profile(){
		return $this->hasOne('Profile', 'user_id');
	}

        // friendship that I started
	function friendsOfMine()
	{
		return $this->belongsToMany('User', 'friends', 'user1_id', 'user2_id')
                    ->wherePivot('accepted', '=', 1) // to filter only accepted
                    ->withPivot('accepted'); // or to fetch accepted value
 	}

	// friendship that I was invited to 
	 function friendOf()
	 {
	 	return $this->belongsToMany('User', 'friends', 'user2_id', 'user1_id')
	 	->wherePivot('accepted', '=', 1)
	 	->withPivot('accepted');
	 }
         
         // get all friend requests
         function friendRequests()
	 {
	 	return $this->belongsToMany('User', 'friends', 'user2_id', 'user1_id')
	 	->wherePivot('accepted', '=', 0)
	 	->withPivot('accepted');
	 }

	 // accessor allowing you call $user->friends
	 public function getFriendsAttribute()
	 {
	 	if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

	 	return $this->getRelation('friends');
	 }

	 protected function loadFriends()
	 {
	 	if ( ! array_key_exists('friends', $this->relations))
	 	{
	 		$friends = $this->mergeFriends();

	 		$this->setRelation('friends', $friends);
	 	}
	 }

	 protected function mergeFriends()
	 {
	 	return $this->friendsOfMine->merge($this->friendOf);
         }
        
        //get only my statuses
        public function myStatuses(){
            return $this->hasMany('Post', 'user_id');
        }
        
        // get all statuses on my wall
        public function statusesOnMyWall(){
            return $this->hasMany('Post', 'posted_to_user_id');
        }
        
        public function getOnProfileStatuses(){
            return NULL;
        }
        
        public function myPosts(){
            $myId = $this->id;
            return Post::where('user_id', $myId, 'AND')->where('posted_to_user_id', $myId)->get();
        }
}