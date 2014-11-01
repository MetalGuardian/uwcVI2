<?php
session_cache_limiter(false);
session_start();
require '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use metalguardian\helpers\Helper;

require '..' . DIRECTORY_SEPARATOR . 'config.php';

Helper::init();

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
	'/stackAccess',
	function () use ($app) {
		$code = $app->request->get('code');
		if (!$code) {
			throw new Exception('Can not get access code');
		}
		Helper::getStackAccessToken($code);
		$app->redirect('/');
	}
);
$app->get(
	'/githubAccess',
	function () use ($app) {
		$code = $app->request->get('code');
		if (!$code) {
			throw new Exception('Can not get access code');
		}
		Helper::getGithubAccessToken($code);
		$app->redirect('/');
	}
);

$app->get(
	'/get-user-info',
	function () use ($app) {
		$stack = (int)$app->request->get('stack');
		$github = $app->request->get('github');

		$stackUser = null;
		if ($stack) {
			// i use user id: 209566
			$stackUser = Helper::getStackUserInfo($stack);
		}

		$githubUser = null;
		if ($github) {
			// i use user login: samdark
			$githubUser = Helper::getGithubUserInfo($github);
		}

		$app->render('view.php', ['stackUser' => $stackUser, 'githubUser' => $githubUser]);
	}
);
$app->get(
	'/flushCache',
	function () use ($app) {
		Helper::getCache()->dropCache();
		$app->redirect('/');
	}
);

$app->run();
