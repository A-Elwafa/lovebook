@extends('main.layout')

@section('content')

@if($users == NULL)
{{ 'No users found.' }}
@else
<div class="searchBox col-sm-12 col-lg-5">
    <div>
        <p>Results for search "{{ $query }}"</p>
    </div>
    @foreach($users as $user)
    <?php
        $friendStatus = App::make('ProfileController')->checkFriendStatus(Auth::user()->id, $user->id);
    ?>
    <div class="row friendRow">
        <div class="col-sm-11 col-lg-11 friendBox">
            @if((Auth::user()->id != $user->id) && $friendStatus['status'] === 'notFriends')
            <div class="editInfo">
                <a class="" href="{{ URL::route('addFriend', $user->id) }}"><button type="button" class="btn btn-default btn-xs">Add friend</button></a>
            </div>
            @elseif($friendStatus['status'] === 'respondToRequest')
            <div class="editInfo">
                <a class="" href="{{ URL::route('getFriendRequests') }}"><button type="button" class="btn btn-default btn-xs">Respond to request</button></a>
            </div>
            @elseif($friendStatus['status'] === 'requestSent')
            <div class="editInfo">
                <a class="" href="#"><button type="button" class="btn btn-default btn-xs">Request sent</button></a>
            </div>
            @elseif($friendStatus['status'] === 'friends')
            <div class="editInfo">
                <a class="" href="{{ URL::route('deleteFriend', $user->id) }}"><button type="button" class="btn btn-default btn-xs">Unfriend</button></a>
            </div>
            @endif
            <div class="miniThWrap">
                <img class="miniThumb" src="{{ asset($user->profile->profile_pic_mini_thumb) }}">
            </div>
            <a class="friendAnchor" href="{{ URL::route('showProfile', $user->id) }}">{{ $user->full_name }}</a>
        </div>
    </div>
    @endforeach
    {{ $users->appends(Input::except('page'))->links() }}
</div>
@endif
    
@stop