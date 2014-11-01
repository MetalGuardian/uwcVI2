<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \Slim\View $this
 * @var \metalguardian\models\StackUser $stackUser
 * @var $githubUser
 */
?>

<!DOCTYPE html>
<html>
<head>
	<title>Metalguardian Recruiting</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="/js/Chart.min.js"></script>
</head>
<body>
<div class="container">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
		<ul class="nav navbar-nav">
			<li class="active"><a href="/">Home</a></li>
		</ul>
	</div>
	<h1>Here you see information about finded users. Or not (if any information was found)</h1>
	<?php $githubUser && $this->display('githubView.php', ['user' => $githubUser]); ?>
	<?php $stackUser && $this->display('stackView.php', ['user' => $stackUser]); ?>
</div>
</body>
</html>
