@extends('main.layout')

@section('content')

<div class="row basicProfile">
    <div class="col-sm-3">
        <div class="profilePicWrap">
            <img src="{{ asset($user->profile->profile_pic_thumb) }}" alt="" class="profileThumb img-thumbnail">
        </div>
        {{ Form::open(array('route' => 'changeProfilePicture', 'files' => 'true')) }}
        {{ Form::file('image') }}
        {{ Form::submit('Upload') }}
        {{ Form::close() }}
        @if( $errors->has("image") )
        {{ $errors->first("image") }}
        @endif
    </div>
    <div class="col-sm-5 infoProfile">
        <div class="editInfo">
            <a class="" href="{{ URL::route('getEditInfo') }}"><button type="button" class="btn btn-default btn-xs">Edit</button></a>
        </div>
        <h2><strong>{{ $user->full_name }}</strong></h2>
        <div class="infoBox">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3 profileLabel control-label">Location</label>
                    <div class="col-sm-6">
                        <p class="form-control-static">{{ $user->profile->location }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 profileLabel control-label">School</label>
                    <div class="col-sm-6">
                        <p class="form-control-static">{{ $user->profile->school }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 profileLabel control-label">Gender</label>
                    <div class="col-sm-6">
                        <p class="form-control-static">{{ $user->profile->gender }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 profileLabel control-label">Date of birth</label>
                    <div class="col-sm-6">
                        <p class="form-control-static">{{ $user->profile->dob_for_profile }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 profileLabel control-label">About me</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">{{ $user->profile->about_me }}</p>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="profileBody">
    
<div class="row">
    <div id="newStatusDiv" class="statusContainer col-lg-6">
        <form id="newStatusForm" method="POST" accept-charset="UTF-8" action="http://www.lovebook.com/ajax" role="form">
            <div class="">
                <textarea name="newStatusText" id="statusArea" placeholder="Update your status..."></textarea>
            </div>
            <input type="submit" id="post" value="Post" class="btn btn-sm myButton">
        </form>
    </div>
</div>
<div class="row posts">
    
    @foreach($statuses as $status)
    <div class="_statusContainer" id="status{{ $status->id }}">
       <div class="_statusHeader">
          <div class="_statusThWrap">
             <img class="miniThumb" src="{{ asset($status->user->profile->profile_pic_mini_thumb) }}">
         </div>
         <a class="friendAnchor" href="{{ URL::route('showProfile', $status->user->id) }}">{{ $status->user->full_name }}</a>
         <p class="timeShare">Shared on {{ $status->date }} at {{ $status->time }}</p>
     </div>
     <p class="_statusBody">{{ $status->content }}</p>
     <div class="_statusBottom">
      <div class="_likeSection">
         <a class="_likeAnchor _statusAnchors" id="like{{ $status->id }}" href="#">@if($status->likes()->where('user_id', '=', Auth::user()->id)->first() == NULL)Like @else Unlike @endif</a>
         <a class="_commentAnchor _statusAnchors" href="#txtArCmnt{{ $status->id }}">Comment</a>
         <a class="_showLikesAnchor _statusAnchors" href="#"><img class="likeButton" src="{{ asset('img/likeButton_icon.png')}}"><span class="likeCount" id="likeCount{{ $status->id }}">{{ $status->likes()->count() }}</span></a>
     </div>
     <div class="_commentSection">
         <div class="_newComment">
            <div class="_commentThWrap">
               <img class="miniThumb" src="{{ asset($status->user->profile->profile_pic_mini_thumb) }}">
           </div>
           <form name="commentForm" id="{{ $status->id }}">
               <div class="_textDiv">
                  <textarea name="commentText" id="txtArCmnt{{ $status->id }}" class="_commentTxtArea" rows="1" placeholder="Write your comment..."></textarea>
              </div>
              <input type="hidden" name="postID" value="{{ $status->id }}">
          </form>
      </div>
  </div>
  <div class="comments" id="comments{{ $status->id }}">
      @if($status->comments != NULL)
      @foreach($status->comments()->orderBy('created_at', 'desc')->get() as $comment)
      {{ View::make('fragments.comment', array('comment' => $comment, 'user' => User::find($comment->user_id))) }}
      @endforeach
      @endif
  </div>
</div>
</div>
@endforeach
</div>
</div>

@stop