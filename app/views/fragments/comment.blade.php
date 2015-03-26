<div class="_commentBox" id="comment{{ $comment->id }}">
	<div class="_commentThWrap">
		<img class="miniThumb" src="{{ asset($user->profile->profile_pic_mini_thumb) }}">
	</div>
	<a class="friendAnchor commentName" href="{{ URL::route('showProfile', $user->id) }}">{{ $user->full_name }}</a>
	<p class="_commentTime">{{ $comment->date }} at {{ $comment->time }}</p>
	<p class="_commentContent">{{ $comment->content }}</p>
</div>