@extends('main.basicBS')

@section('content')

<div class="customJumbotron">
    <div class="jumbotron">
        <h2>Welcome to Lovebook</h2>
        <p>Welcome to the next generation of social networking!</p>
        <p>Connect with your friends and share your story!</p>
        <p>
            <a class="btn btn-danger btn-md" href="{{ URL::route("register") }}">Go to registration page!</a>
        </p>
    </div>
</div>
@if(Session::has('global'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {{ Session::get('global') }}</div>
@endif
{{ Form::open(array('route' => 'postLogin', 'role' => 'form', 'class' => 'form-signin col-sm-4 col-sm-offset-4')) }}
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="email" class="form-control" placeholder="Email address" required autofocus name="email" id="email">
    <input type="password" class="form-control" placeholder="Password" required name="password" id="password">
    <label class="checkbox">
    <input type="checkbox" name="remember" value="remember-me">Remember me</label>
    {{ Form::token() }}
    <button class="btn btn-md btn-danger btn-block" type="submit">Sign in</button>
</form>

@stop