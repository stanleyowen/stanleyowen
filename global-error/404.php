<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>404 Not Found | Stanley Owen</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900">
	<link type="text/css" rel="stylesheet" href="https://eternityesports.000webhostapp.com/assets/css/style-error.css">
</head>

<body oncontextmenu = "return false">
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2>404 - Page not found</h2>
			<p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a onclick="goBack()" href="#">Back</a>
		</div>
	</div>
	<script>
	document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
			return false;
		}
	}
	</script>
	<script>
	function goBack() {
	  window.history.back();
	}
	</script>
</body>

</html>
