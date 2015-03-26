@extends('main.layout')

@section('content')

@if($users != NULL)
<div class="searchBox col-sm-12 col-lg-5">
    <div>
        <p>{{ $countMessage }}</p>
    </div>
    @foreach($users as $user)
    <div class="row friendRow">
            <div class="col-sm-11 col-lg-11 friendBox">
                <div class="editInfo">
                    <form method="POST" action="{{ URL::route('postFriendRequests') }}">
                        <input name="action" type="submit" value="Confirm" class="btn btn-default btn-xs"></input>
                        <input name="action" type="submit" value="Decline" class="btn btn-default btn-xs"></input>
                        <input name="userId" type="hidden" value="{{ $user->id }}">
                        {{ Form::token() }}
                    </form>
                </div>
                <div class="miniThWrap">
                    <img class="miniThumb" src="{{ asset($user->profile->profile_pic_mini_thumb) }}">
                </div>
                <a class="friendAnchor" href="{{ URL::route('showProfile', $user->id) }}">{{ $user->full_name }}</a>
            </div>
    </div>
    @endforeach
</div>
@else
<div>
    <p>{{ $countMessage }}</p>
</div>
@endif

@stop