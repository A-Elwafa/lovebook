<?php

class PostsController extends BaseController {
    // user posts new status (on his own profile)
    // has validation
    public function postAjaxStatus(){
        $inputData = Input::get('formData');
        
        parse_str($inputData, $formFields);
        
        $statusContent = htmlentities($formFields['newStatusText']);
        
        $newStatus = new Post;
        $newStatus->user_id = Auth::user()->id;
        $newStatus->posted_to_user_id = Auth::user()->id;
        $newStatus->content = $statusContent;
        $newStatus->save();
        
        $lastStatus = User::find(Auth::user()->id)->MyStatuses()
                ->orderBy('created_at', 'desc')->first();
        
        $viewData = array(
            'statusContent' => $statusContent,
            'user' => Auth::user(),
            'status' => $lastStatus
                );
        
        $viewHtml = View::make('fragments/status', $viewData)->render();
        
        return Response::json(array('success' => true, 'html' => $viewHtml));
    }
    
    // posts comment to post; has validation (user that comments must comment either his own post or his friends post)
    public function ajaxComment(){
        $inputData = Input::get('formData');
        
        parse_str($inputData, $formFields);
        
        $commentContent = htmlentities($formFields['commentText']);
        $postID = (int)$formFields['postID'];
        
        $newComment = new Comment;
        $newComment->user_id = Auth::user()->id;
        $newComment->post_id = $postID;
        $newComment->content = $commentContent;
        $newComment->save();
        
        $viewData = array(
            'comment' => $newComment,
            'user' => User::find(Auth::user()->id)
        );
        
        $commentHTML = View::make('fragments/comment', $viewData)->render();
        
        return Response::json(array('success' => true, 'comment' => $commentHTML, 'comments' => ('comments' . $newComment->post_id)));
    }
    
    // posts to friends profile; has validation whether ursers are friends
    // returns JSON file with new post HTML, then on client side it is appended page page(real time updating)
    public function postToWall(){
        $inputData = Input::get('formData');
        
        parse_str($inputData, $formFields);
        
        $statusContent = htmlentities($formFields['newStatusText']);
        
        $postedUserID = (int)$formFields['user_id'];
        $friendStatus = App::make('ProfileController')->checkFriendStatus(Auth::user()->id, $postedUserID);
        
        if($friendStatus['status'] != 'friends'){
            return Response::json(array('success' => false));
        }
        
        $newStatus = new Post;
        $newStatus->user_id = Auth::user()->id;
        $newStatus->posted_to_user_id = $postedUserID;
        $newStatus->content = $statusContent;
        $newStatus->save();
        
        $viewData = array(
            'statusContent' => $newStatus->content,
            'user' => Auth::user(),
            'status' => $newStatus
        );
        
        $viewHtml = View::make('fragments/status', $viewData)->render();
        
        return Response::json(array('success' => true, 'html' => $viewHtml));
    }
    
    // it likes post; has validation algorithms, returns JSON file with info whether post is liked or not; on client side
    // it triggers function for showing "Like" or "Unlike" anchor (button)
    public function likePost(){
        if(Input::isJson()){
            $data = Input::all();
            $postID = $data['postID'];
            
            $likedPost = Post::findOrFail($postID);
            
            //if post exists and if user can see and like the post
            if((!is_null($likedPost))
                    && ((App::make('ProfileController')->checkFriendStatus(Auth::user()->id, $likedPost->posted_to_user_id)['status'] === 'friends')
                            || Auth::user()->id == $likedPost->posted_to_user_id)
                    )
            {
                $checkIfLiked = $likedPost->likes()->where('user_id', '=', Auth::user()->id)->first();
                if($checkIfLiked != NULL){
                    $checkIfLiked->delete();
                    
                    return Response::json(array('success' => true, 'liked' => true,'anchor' => '#like'.$postID));
                }
                
                $newLike = new Like;
                $newLike->post_id = $postID;
                $newLike->user_id = Auth::user()->id;
                $newLike->save();
                
                return Response::json(array('success' => true, 'liked' => false,'anchor' => '#like'.$postID));
            }
            else{
                return Response::json(array('postID_' => 'fail1'));
            }
        }
        else{
                return Response::json(array('postID_' => 'notJson'));
            }
    }
    
    // return JSON file including bootstrap JS modal with list of users that liked post
    public function getUsersThatLiked(){
        if(Input::isJson()){
            $data = Input::all();
            $postID = $data['postID'];
            
            $modalHTML = View::make('likeModal', array(
                'likes' => Post::find($postID)->likes,
            ))->render();
                        
            return Response::json(array('success' => true, 'html' => $modalHTML));
        }
        else{
            return;
        }
    }
}