@extends('main.layout')

@section('content')

<div class="row basicProfile">
    <div class="col-sm-3">
        <div class="profilePicWrap">
            <img src="{{ asset($user->profile->profile_pic_thumb) }}" alt="" class="profileThumb img-thumbnail">
        </div>
        @if($user->id == Auth::user()->id)
        {{ Form::open(array('route' => 'changeProfilePicture', 'files' => 'true')) }}
        {{ Form::file('image') }}
        {{ Form::submit('Upload') }}
        {{ Form::close() }}
        @if( $errors->has("image") )
        {{ $errors->first("image") }}
        @endif
        @endif
    </div>
    <div class="col-sm-5 infoProfile">
        @if($friendStatus === 'notFriends')
        <div class="editInfo">
            <a class="" href="{{ URL::route('addFriend', $user->id) }}"><button type="button" class="btn btn-default btn-xs">Add friend</button></a>
        </div>
        @elseif($friendStatus === 'editProfile')
        <div class="editInfo">
            <a class="" href="{{ URL::route('getEditInfo') }}"><button type="button" class="btn btn-default btn-xs">Edit</button></a>
        </div>
        @elseif($friendStatus === 'requestSent')
        <div class="editInfo">
            <a class="" href="#"><button type="button" class="btn btn-default btn-xs">Request sent</button></a>
        </div>
        @elseif($friendStatus === 'friends')
        <div class="editInfo">
            <a class="" href="{{ URL::route('deleteFriend', $user->id) }}"><button type="button" class="btn btn-default btn-xs">Unfriend</button></a>
        </div>
        @else
        <div class="editInfo">
            <a class="" href="{{ URL::route('getFriendRequests') }}"><button type="button" class="btn btn-default btn-xs">Respond to request</button></a>
        </div>
        @endif
        
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

<p class="notFriendsMessage">You are not friend with this person.</p>

</div>

@stop