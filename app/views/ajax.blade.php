@extends('main.basicBS')

@section('content')
<div class="row">
	<div id="newStatusDiv" class="statusContainer col-lg-6">
	    <form id="newStatusForm" method="POST" accept-charset="UTF-8" action="{{ URL::route('postAjaxStatus') }}" role="form">
	        <div class="">
	            <textarea name="newStatusText" id="statusArea" placeholder="Update your status..."></textarea>
	        </div>
	        <input type="submit" id="post" value="Post" class="btn btn-sm myButton">
	    </form>
	</div>
</div>
<div class="row posts">
</div>
@stop