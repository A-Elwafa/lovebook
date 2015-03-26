<?php

class ProfileController extends BaseController
{
        // shows profile by id
        public function show($id) {
        $user = User::find($id);
        
        if(!$user){
            return Redirect::route('home')->with('global', 'Sorry, no user.');
        }
        
        $title = $user->full_name .' - Profile';
        
        // first check that wheter this is profile of logged in user and return his profile page
        if(Auth::user()->id != $id){
            $friendStatus = $this->checkFriendStatus(Auth::user()->id, $id);
            //dd($friendStatus['status']);
            // if not friends
            if($friendStatus['status'] !== 'friends'){
                
                return View::make('profile.notFriendsProfile')->with(array(
                    'user' => $user,
                    'title' => $title,
                    'friendStatus' => $friendStatus['status'],
                ));
            }
            else{
                return View::make('profile.friendsProfile')->with(array(
                    'user' => $user,
                    'title' => $title,
                    'friendStatus' => $friendStatus['status'],
                    'statuses' => $user->statusesOnMyWall()->orderBy('created_at', 'desc')->get(),
                ));
            }
        }
        else{
            $friendStatus = array('status' => 'editProfile');
            return View::make('profile.myProfile')->with(array(
            'user' => $user,
            'title' => $title,
            'friendStatus' => $friendStatus['status'],
            'statuses' => $user->statusesOnMyWall()->orderBy('created_at', 'desc')->get(),
        )); 
            
        }
              
    }
    
    
    // CHECKS IF 2 PERSONS ARE FRIENDS BY ID
    // first argument MUST be authenticated user id
    // returns associative array wih 2 key values: 'status' and 'friendshipInfo'
    // 'status' key refers to string and represents friendship status
    // 4 possible values for 'status' key:
    //  'notFriends' = users aren't friends, 'friends' = users are friends
    //  'requestSent' = auth. user has sent request to other user
    //  'respondToRequest' = friendship request has been sent to auth. user
    // key 'object' is a Friend model type object and holds info about friendship
    // which can be retrieved through object methods
    public function checkFriendStatus($authUserId, $secondUserId){

    $check1 = Friend::where(function($query) use($authUserId){
        $query->where('user1_id', $authUserId);
    })->where(function($query) use($secondUserId){
        $query->where('user2_id', $secondUserId);
    })->first();                       

    if($check1 == NULL){
        $check2 = Friend::where(function($query) use($secondUserId){
            $query->where('user1_id', $secondUserId);
        })->where(function($query) use($authUserId){
            $query->where('user2_id', $authUserId);
        })->first();

        if($check2 == NULL){
            return array('status' => 'notFriends', 'friendshipInfo' => NULL);
        } elseif($check2->accepted == 0){
            return array('status' => 'respondToRequest', 'friendshipInfo' => $check2);
        } else{
            return array('status' => 'friends', 'friendshipInfo' => $check2);
        }

    } elseif($check1->accepted == 0){
        return array('status' => 'requestSent', 'friendshipInfo' => $check1);
    } else{
        return array('status' => 'friends', 'friendshipInfo' => $check1);
    }
}


    // change profile picture
    public function changeProfilePicture() {
        $image = Input::all();
        
        $validator = Validator::make($image, array(
            'image' => 'required|image|max:3072'
        ));
        
        if($validator->fails()){
            return Redirect::route('showProfile', Auth::user()->id)
                    ->withErrors($validator);
        }
        
        $extension = $image['image']->getClientOriginalExtension();
        $imageName = str_random(20);
        $destination = 'img/uploads/';
                
        $upload_success = Input::file('image')->move($destination, $imageName.'.'.$extension);
        
        // if upload is successful save picture information
        if($upload_success){
            $user = User::findOrFail(Auth::user()->id);
            $user->profile->profPic_path = $destination;
            $user->profile->profPic_name = $imageName;
           
            
            
            // creating thumbnail and mini thumbnail
            $fullPathName = $destination. $imageName.'.'.$extension;
                    
            $fullThumbPathName = public_path($destination . 'thumbs/' . $imageName . '_thumb.' . $extension);
            
            $imgThumb = Image::make($fullPathName);
            $imgThumb->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgThumb->save($fullThumbPathName);
            
            $user->profile->profPic_path_thumb = $destination . 'thumbs/';
            $user->profile->profPic_name_thumb = $imageName . '_thumb.' . $extension;
            
            $fullMiniThumbPathName = public_path($destination . 'minithumbs/' . $imageName . '_minithumb.' . $extension);
            
            $imgMiniThumb = Image::make($fullPathName);
            $imgMiniThumb->resize(55, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgMiniThumb->save($fullMiniThumbPathName);
            
            $user->profile->profPic_path_mini_thumb = $destination . 'minithumbs/';
            $user->profile->profPic_name_mini_thumb = $imageName . '_minithumb.' . $extension;
                    
            $user->profile->save();
            return Redirect::route('showProfile', Auth::user()->id);
        };
    }
    
    public function getEditInfo(){
        $user = Auth::user();
        
        $title = "Lovebook - Edit basic info";
        
        return View::make('profile.editInfo')->with(array(
            'user' => $user->profile,
            'title' => $title
        ));
    }
    
    public function postEditInfo(){
        $input = Input::all();
        $validator = Validator::make($input, array(
            'location' => 'max:60',
            'school' => 'max:100',
            'gender' => 'required|in:male,female|max:6',
            'dob' => 'date|date_format:Y-m-d',
            'about_me' => '',
        ));
        
        if($validator->fails()){
            return  Redirect::route('getEditInfo')
                    ->withErrors($validator)
                    ->withInput();
        }
        
        $profile = Profile::find(Auth::user()->id);
        $profile->location = $input['location'];
        $profile->school = $input['school'];
        $profile->gender = $input['gender'];
        $profile->dob = $input['dob'];
        $profile->about_me = $input['about_me'];
        $profile->save();
        
        return Redirect::route('showProfile', $profile->user_id );
    }
    
    public function addFriend($addedFriendId){
        // check if user is trying to add himself (possible via get url)
        if(Auth::user()->id == $addedFriendId)
            return Redirect::route('showProfile', Auth::user()->id)
                ->with('global', 'You cannot add yourself!');
        
        // if they are already friends redirect to home
        $friendStatus = $this->checkFriendStatus(Auth::user()->id, $addedFriendId);
        if($friendStatus['status'] === 'friends'){
            return Redirect::route('home');
        }
        
        // send request
        $friendship = new Friend;
        $friendship->user1_id = Auth::user()->id;
        $friendship->user2_id = $addedFriendId;
        $friendship->save();
        
        return Redirect::route('showProfile', $addedFriendId)
            ->with('global', 'Friend request sent.');
    }
    
    public function deleteFriend($deletedFriend){
        $friendStatus = $this->checkFriendStatus(Auth::user()->id, $deletedFriend);
        
        if($friendStatus['status'] !== 'friends')
            return Redirect::route('showProfile', $deletedFriend);
        
        if($friendStatus['status'] === 'friends'){
            $friendStatus['friendshipInfo']->delete();
            unset($friendStatus);
            return Redirect::route('showProfile', $deletedFriend);
        }
        
    }
    
    
    public function getFriendRequests(){
        $users = User::find(Auth::user()->id)->friendRequests;
        
        $title = 'Friend requests';
        $count = count($users);
        
        if($count > 0){
            
            if($count != 1){
                $countMessage = 'You have ' .$count.' friend requests.';
            } else{
                $countMessage = 'You have 1 friend request.';
            }
        }
        else{
            $countMessage = 'You have no friend requests.';
        }
        
        return View::make('requestsPage')->with(array(
                'users' => $users,
                'title' => $title,
                'countMessage' => $countMessage,
            ));
    }
    
    
    
    public function postFriendRequests(){
        $input = Input::all();
        
        $validator = Validator::make($input, array(
            'action' => 'required|alpha|in:Confirm,Decline',
            'userId' => 'required|integer'
        ));
        
        if($validator->fails()){
            return Redirect::route('getFriendRequests')
                    ->with('global', 'Something went wrong');
        } else{
            $friendStatus = $this->checkFriendStatus(Auth::user()->id, $input['userId']);
            if($friendStatus['status'] === 'respondToRequest'){
                $userThatRequested = $input['userId'];
                $friendship = Friend::where(function($query) use($userThatRequested){
                    $query->where('user1_id', $userThatRequested);
                })->where(function($query){
                    $query->where('user2_id', Auth::user()->id);
                })->first();
                if($input['action'] === 'Confirm'){
                    $friendship->accepted = 1;
                    $friendship->save();
                }elseif($input['action'] === 'Decline'){
                    $friendship->delete();
                }
                
                return Redirect::route('getFriendRequests');
            }else{
                return Redirect::route('getFriendRequests');
            }
        }
    }
    
    public function cancelRequest(){
        
    }
    
    public function search(){
        $input = htmlentities(Input::get('q'));
        
        $searchedUsers = $this->searchUsersByName($input);
        
        
        $title = 'Search';
        return View::make('searchPage')
                ->with(['title' => $title,
                    'query' => $input,
                    'users' => $searchedUsers,
                    ]);
    }
    
    // very basic and bad search
    public function searchUsersByName($query){
        $searchedString = html_entity_decode($query);
        $names = explode(' ', $searchedString, '3');
        if(count($names) == 1){
            if($names[0] == ''){
                return NULL;
            }
            return User::where('first_name', 'like', '%' . $names[0] . '%')
                ->orWhere('last_name', 'like', '%'. $names[0] . '%')
                ->paginate(15);
        }
        elseif(count($names) == 2){
            return User::where(function($query) use($names){
                        $query->where('first_name', 'like', '%' . $names[0] . '%');
                    })->where(function($query) use($names){
                        $query->where('last_name', 'like', '%' . $names[1] . '%');
                    })->orWhere(function($query) use($names){
                        $query->where('first_name', 'like', '%' . $names[1] . '%');
                    })->where(function($query) use($names){
                    $query->where('last_name', 'like', '%' . $names[0] . '%');
                    })->paginate(15);
        }
        return NULL;
    }
    
    public function GetFriendRequestsFrom($userId){
        return Friend::where(function($query) use($userId){
            $query->where('user2_id', $userId);
        })->where(function($query){
            $query->where('accepted', 0);
        });
    }
}