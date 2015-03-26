<div class="statusContainer col-lg-6">
    <div class="row statusHeader">
        <div class="miniThWrap">
            <img class="miniThumb" src="{{ asset($user->profile->profile_pic_mini_thumb) }}">
            </div>
            <a class="friendAnchor" href="#">{{ $user->full_name }}</a>
            <p class="timeShare">Shared on {{ $lastStatus->date }} at {{ $lastStatus->time }}</p>
    </div>
    <div class="statusBody">
        <p>{{ $lastStatus->content }}</p>
    </div>
</div>