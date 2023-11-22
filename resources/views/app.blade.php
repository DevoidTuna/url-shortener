<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@vite('resources/css/app.css')
</head>
<body>
  <div id="app"></div>
	@vite('resources/js/main.ts')
</body>
</html>
