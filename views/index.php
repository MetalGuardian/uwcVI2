<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 *
 */
?>

<!DOCTYPE html>
<html>
<head>
	<title>Metalguardian Recruiting</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<form method="get" action="/get-user-info">
		<div class="form-group">
			<label for="email">Email address</label>
			<input type="email" id="email" class="form-control" name="email" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" id="name" class="form-control" name="name" placeholder="Your name">
		</div>
		<div class="form-group">
			<label for="stack">Stack user id</label>
			<input type="text" id="" class="form-control" name="stack" placeholder="Stack user id">
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
</body>
</html>
