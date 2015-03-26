@extends('main.basicBS')

@section('content')
<div class="customJumbotron">
    <div class="jumbotron">
      <h2>Register and experience Lovebook!</h2>
      <p>After you register we will send you an e-mail with activation link.</p>
      <p><a class="btn btn-danger btn-md" role="button" href="{{ URL::route('getLogin')}}">Go to log in page.</a></p>
    </div>
</div>
<div class="col-sm-6 col-sm-offset-3">
    {{ Form::open(array('route' => 'register', 'class' => 'form-horizontal')) }}

    <div class="form-group">
    	{{ Form::label('first_name', 'First name:', array('class' => 'control-label')) }}
    	{{ Form::text('first_name', NULL, array("required" => "", 'class' => 'form-control', 'placeholder' => 'First name')) }}
            @if( $errors->has('first_name') )
                {{ $errors->first("first_name") }}
            @endif
    </div>

    <div class="form-group">
            {{ Form::label("middle_name", "Middle name (optional):", array('class' => 'control-label')) }}
            {{ Form::text('middle_name', NULL, array('class' => 'form-control', 'placeholder' => 'Middle name')) }}
            @if( $errors->has("middle_name") ) {{ $errors->first("middle_name") }}@endif
    </div>

    <div class="form-group">
    	{{ Form::label('last_name', 'Last name:', array('class' => 'control-label')) }}
    	{{ Form::text('last_name', NULL, array("required" => "", 'class' => 'form-control', 'placeholder' => 'Last Name')) }}
            @if( $errors->has("last_name") )
                {{ $errors->first("last_name") }}
            @endif
    </div>

    <div class="form-group">
    	{{ Form::label('email', 'E-mail:', array('class' => 'control-label')) }}
    	{{ Form::text('email', NULL, array("required" => "", 'class' => 'form-control', 'placeholder' => 'E-mail')) }}
            @if( $errors->has("email") )
                {{ $errors->first("email") }}
            @endif
    </div>
    <div class="form-group">
    	{{ Form::label('password', 'Password:', array('class' => 'control-label')) }}
    	{{ Form::password('password', array("required" => "", 'class' => 'form-control', 'placeholder' => 'Password')) }}
            @if( $errors->has("password") )
                {{ $errors->first("password") }}
            @endif
    </div>
    <div class="form-group">
    	{{ Form::label('password_again', 'Repeat password:', array('class' => 'control-label')) }}
    	{{ Form::password('password_again',  array("required" => "", 'class' => 'form-control', 'placeholder' => 'Repeat password')) }}
            @if( $errors->has("password_again") )
                {{ $errors->first("password_again") }}
            @endif
    </div>
    <div class="form-group">
    	{{ Form::token() }}
    	{{ Form::submit("Register!", array('class' => 'btn btn-danger btn-md')) }}
    </div>
            
    {{ Form::close() }}
</div>

@stop