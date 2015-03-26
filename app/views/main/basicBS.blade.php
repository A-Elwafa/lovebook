<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.autosize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{ asset('favicon.ico')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <title>{{ $title }}</title>
</head>
<body>
	<div class="container">
		@yield('content')
	</div>
</body>
</html>