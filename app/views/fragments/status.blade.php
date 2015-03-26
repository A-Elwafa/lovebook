<div class="_statusContainer col-lg-6 col-sm-12" id="status{{ $status->id }}">
	<div class="_statusHeader">
		<div class="_statusThWrap">
			<img class="miniThumb" src="{{ asset($user->profile->profile_pic_mini_thumb) }}">
		</div>
		<a class="friendAnchor" href="{{ URL::route('showProfile', $user->id) }}">{{ $status->user->full_name }}</a>
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
					<img class="miniThumb" src="{{ asset(Auth::user()->profile->profile_pic_mini_thumb) }}">
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
		@foreach($status->comments()->orderBy('created_at', 'asc')->get() as $comment)
		{{ View::make('fragments.comment', array('comment' => $comment, 'user' => User::find($comment->user_id))) }}
		@endforeach
		@endif
		</div>
	</div>
</div>