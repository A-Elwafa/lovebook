@extends('main.basicBS')

@section('content')

<div class="row statusContainer col-lg-6">
    <form method="POST" accept-charset="UTF-8" action="#" role="form">
        <div class="">
            <textarea name="newStatusText" id="statusArea" placeholder="Update your status..."></textarea>
        </div>
        <input type="submit" value="Post" class="btn btn-sm myButton">
    </form>
</div>

@stop