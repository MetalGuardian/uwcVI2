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
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
		<ul class="nav navbar-nav">
			<li class="active"><a href="/">Home</a></li>
		</ul>
	</div>

	<h1>Set up person params</h1>
	<form method="get" action="/get-user-info">
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
		<p><a href="<?= Helper::getStackLoginLink(); ?>">Grant access to stack overflow</a></p>
	<?php else : ?>
		<p>We have stack overflow access token</p>
	<?php endif; ?>

	<?php if (!Helper::hasValidGithubToken()) : ?>
		<p><a href="<?= Helper::getGithubLoginLink(); ?>">Grant access to github</a></p>
	<?php else : ?>
		<p>We have github access token</p>
	<?php endif; ?>

	<p><a href="/flushCache">Flush cache</a></p>
</div>
</body>
</html>
