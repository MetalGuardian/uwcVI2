<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \Slim\View $this
 * @var \metalguardian\models\StackUser $stackUser
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
	<?php $this->display('stackView.php', ['user' => $stackUser]); ?>
</div>
</body>
</html>
