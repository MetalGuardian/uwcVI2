<?php
/**
 * Author: metal
 * Email: metal
 */
use metalguardian\helpers\Helper;

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
	<h1>Set up person params</h1>
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
			<input type="text" id="stack" class="form-control" name="stack" placeholder="Stack user id">
		</div>
		<div class="form-group">
			<label for="gihub">Github user login</label>
			<input type="text" id="gihub" class="form-control" name="github" placeholder="Github user login">
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
	</form>
	<h1>Other functions</h1>
	<?php if (!Helper::hasValidStackToken()) : ?>
		<a href="<?= Helper::getStackLoginLink(); ?>">Grant access to stack overflow</a>
	<?php endif; ?>
</div>
</body>
</html>
