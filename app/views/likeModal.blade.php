<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">People who liked this post</h4>
      </div>
      <div class="modal-body">
        @if($likes === NULL)
        {{ 'No users found.' }}
        @endif
        @foreach($likes as $like)
        <?php
        $friendStatus = App::make('ProfileController')->checkFriendStatus(Auth::user()->id, $like->user->id);
        ?>
        <div class="row friendRow">
          <div class="col-sm-11 col-lg-11 friendBox">
            @if((Auth::user()->id != $like->user->id) && $friendStatus['status'] === 'notFriends')
            <div class="editInfo">
              <a class="" href="{{ URL::route('addFriend', $like->user->id) }}"><button type="button" class="btn btn-default btn-xs">Add friend</button></a>
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
              <a class="" href="{{ URL::route('deleteFriend', $like->user->id) }}"><button type="button" class="btn btn-default btn-xs">Unfriend</button></a>
            </div>
            @endif
            <div class="miniThWrap">
              <img class="miniThumb" src="{{ asset($like->user->profile->profile_pic_mini_thumb) }}">
            </div>
            <a class="friendAnchor" href="{{ URL::route('showProfile', $like->user->id) }}">{{ $like->user->full_name }}</a>
          </div>
        </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>