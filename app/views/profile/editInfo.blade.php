@extends('main.layout')

@section('content')
<div class="col-sm-4">
    {{ Form::open(array('route' => 'postEditInfo', 'role' => 'form')) }}
    <div class="form-group">
        {{ Form::label('location') }}
        {{ Form::text('location', $user->location, array('class' => 'form-control input-sm')) }}
        @if( $errors->has('location') )
            {{ $errors->first('location') }}
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('school') }}
        {{ Form::text('school', $user->school, array('class' => 'form-control input-sm')) }}
        @if( $errors->has('school') )
           {{ $errors->first('school') }}
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('gender') }}
        {{ Form::select('gender', array('male' => 'Male', 'female' => 'Female'), strtolower($user->gender), array('class' => 'form-control input-sm')) }}
        @if( $errors->has('gender') )
           {{ $errors->first('gender') }}
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('dob', 'Date of birth') }}
        <input class="form-control input-sm" min="1900-01-01" max="2000-01-01" name="dob" type="date" value="{{ $user->dob_for_edit }}">
        @if( $errors->has('dob') )
           {{ $errors->first('dob') }}
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('about_me', 'About me') }}
        <textarea name="about_me" cols="50" rows="10" class="form-control input-sm">{{ $user->about_me }}</textarea>
        @if( $errors->has('about_me') )
           {{ $errors->first('about_me') }}
        @endif
    </div>
    <button type="submit" class="btn btn-default">Save</button>
    {{ Form::close() }}
</div>
@stop