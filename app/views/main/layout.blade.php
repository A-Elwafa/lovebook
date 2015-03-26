<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
   	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
	<!-- Latest compiled and minified CSS -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{ asset('favicon.ico')}}">
	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css"> -->
	
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="{{ asset('js/jquery.autosize.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
        <title>{{ $title}} </title>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::route('home') }}">Looovebook</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					
                                    <form id="searchForm" method="GET" action="{{ URL::route('searchPage') }}" class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input name="q" type="text" class="form-control" placeholder="Search">
						        <input type="submit" value="Search" class="btn btn-default"></input>
                                                </div>
                                        </form>
					<ul class="nav navbar-nav navbar-right">
                                                 <li @if(Route::current()->getName() == 'home') class="active" @endif ><a href="{{ URL::route('home') }}">Home</a></li>
                                                 <li @if(Route::current()->GetName() == 'showProfile' && $user->id == Auth::user()->id) class="active" @endif >
                                                    <a href="{{ URL::route('showProfile', Auth::id()) }}"> {{ Auth::user()->full_name }}</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{ URL::route('getFriendRequests') }}">Friend requests</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li><a href="javascript:void(0)">Love Feed settings</a></li>
                                                            <li><a href="javascript:void(0)">Privacy</a></li>
                                                            <li><a href="javascript:void(0)">Help</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=" {{ URL::route('logout') }} ">Log out</a></li>
							</ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</nav>
            
                @if(Session::has('global'))
                <p> {{ Session::get('global') }} </p>
                @endif

		@yield('content')

                <footer class="col-sm-12">
			<p>&copy Looovebook 2015</p>
		</footer>
	</div>
</body>
</html>