
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>404 - Not Found</title>
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="{{asset('public/frontend/css/errors.css
    ')}}" />
</head>
<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<div></div>
				<h1>404</h1>
			</div>
			<h2>Page not found</h2>
			<p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a href="{{route('main.page')}}">home page</a>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>