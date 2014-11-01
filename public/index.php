<?php
require '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use metalguardian\helpers\Helper;

require '..' . DIRECTORY_SEPARATOR . 'config.php';

ActiveRecord\Config::initialize(
	function(\ActiveRecord\Config $cfg) {
		$cfg->set_model_directory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models');
		$cfg->set_connections(['development' => MYSQL_CONNECTION_STRING]);
	}
);

$app = new \Slim\Slim(
	[
		'templates.path' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views'
	]
);
$app->get(
	'/',
	function () use ($app) {

		$app->render('index.php', []);
	}
);
$app->get(
	'/get-user-info',
	function () use ($app) {
		$email = $app->request->get('email');
		$name = $app->request->get('name');
		$stack = (int)$app->request->get('stack');
		$stackUser = null;
		if ($stack) {
			$stackUser = Helper::getStackUserInfo($stack);
		}

		$app->render('view.php', ['stackUser' => $stackUser,]);
	}
);

$app->run();
