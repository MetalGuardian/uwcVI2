<?php
/**
 * Author: metal
 * Email: metal
 */

namespace metalguardian\helpers;

use Curl\Curl;
use Desarrolla2\Cache\Adapter\File;
use Desarrolla2\Cache\Cache;
use metalguardian\models\StackUser;

/**
 * Class Helper
 * @package metalguardian\helpers
 */
class Helper
{
	protected static $stackPoint = 'https://api.stackexchange.com';
	protected static $githubPoint = 'https://api.github.com';

	/** @var Cache */
	protected static $cache;

	public static function init()
	{
		$cacheDir = '../cache';
		$adapter = new File($cacheDir);
		$adapter->setOption('ttl', 3600);
		static::$cache = new Cache($adapter);
	}

	public static function getCache()
	{
		return static::$cache;
	}

	public static function getStackUserInfo($id)
	{
		$user = static::$cache->get('stack-user-info');
		if ($user === false) {
			$curl = new Curl();
			$curl->setOpt(CURLOPT_ENCODING, 'gzip');
			$curl->get(
				static::$stackPoint . '/2.2/users/' . $id,
				[
					'order' => 'desc',
					'sort' => 'reputation',
					'site' => 'stackoverflow',
					'access_token' => static::getStackToken(),
					'key' => STACK_KEY,
				]
			);
			$response = $curl->response;
			if (isset($response->error_id)) {
				throw new \Exception(isset($response->error_message) ? $response->error_message : 'Unknown error');
			}
			/** @var StackUser $user */
			$user = isset($response->items[0]) ? $response->items[0] : null;

			if (!$user) {
				return false;
			}
			$user->tags = static::getStackUserTags($id);
			$user->topTags = static::getStackUserTopTags($id);

			static::$cache->set('stack-user-info', $user);
		}

		return $user;
	}

	public static function getStackUserTags($id)
	{
		$tags = static::$cache->get('stack-user-tags');
		if ($tags === false) {
			$curl = new Curl();
			$curl->setOpt(CURLOPT_ENCODING, 'gzip');
			$curl->get(
				static::$stackPoint . '/2.2/users/' . $id . '/tags',
				[
					'order' => 'desc',
					'sort' => 'popular',
					'site' => 'stackoverflow',
					'access_token' => static::getStackToken(),
					'key' => STACK_KEY,
				]
			);
			$response = $curl->response;
			if (isset($response->error_id)) {
				throw new \Exception(isset($response->error_message) ? $response->error_message : 'Unknown error');
			}
			$tags = isset($response->items) ? $response->items : [];

			static::$cache->set('stack-user-tags', $tags);
		}

		return $tags;
	}

	public static function getStackUserTopTags($id)
	{
		$tags = static::$cache->get('stack-user-top-tags');
		if ($tags === false) {
			$curl = new Curl();
			$curl->setOpt(CURLOPT_ENCODING, 'gzip');
			$curl->get(
				static::$stackPoint . '/2.2/users/' . $id . '/top-tags',
				[
					'site' => 'stackoverflow',
					'access_token' => static::getStackToken(),
					'key' => STACK_KEY,
				]
			);
			$response = $curl->response;
			if (isset($response->error_id)) {
				throw new \Exception(isset($response->error_message) ? $response->error_message : 'Unknown error');
			}
			$tags = isset($response->items) ? $response->items : [];

			static::$cache->set('stack-user-top-tags', $tags);
		}

		return $tags;
	}

	public static function getStackLoginLink()
	{
		$params = [
			'client_id' => STACK_CLIENT_ID,
			'redirect_uri' => STACK_REDIRECT_URL,
		];
		return 'https://stackexchange.com/oauth?' . http_build_query($params);
	}

	public static function getStackAccessToken($code)
	{
		$curl = new Curl();
		$curl->setOpt(CURLOPT_ENCODING, 'gzip');
		$curl->post(
			'https://stackexchange.com/oauth/access_token',
			[
				'client_id' => STACK_CLIENT_ID,
				'client_secret' => STACK_CLIENT_SECRET,
				'code' => $code,
				'redirect_uri' => STACK_REDIRECT_URL,
			]
		);

		$response = $curl->response;
		if (isset($response->error_id)) {
			throw new \Exception(isset($response->error_message) ? $response->error_message : 'Unknown error');
		}

		if (!preg_match('/access_token=(.*)&expires=(.[0-9]*)/', $response, $matches)) {
			throw new \Exception('Can not get access token');
		}

		$token = $matches[1];
		$expire = $matches[2];
		static::setStackTokenAndExpire($token, $expire);
	}

	public static function setStackTokenAndExpire($token, $expire)
	{
		$_SESSION['stack_token'] = $token;
		$_SESSION['stack_expire'] = time() + $expire;
	}

	public static function getStackToken()
	{
		if (!static::hasValidStackToken()) {
			throw new \Exception('You have no access token! Please, go to index page and take access tokens');
		}
		return $_SESSION['stack_token'];
	}

	/**
	 * @return bool
	 */
	public static function hasValidStackToken()
	{
		if (isset($_SESSION['stack_token']) && $_SESSION['stack_token'] && isset($_SESSION['stack_expire']) && $_SESSION['stack_expire'] > time()) {
			return true;
		}
		return false;
	}



	public static function getGithubUserInfo($id)
	{
		$user = static::$cache->get('github-user-info');
		if ($user === false) {
			$curl = new Curl();
			$curl->setHeader('Accept', 'application/vnd.github.v3+json');
			$curl->setHeader('Authorization', 'token ' . static::getGithubToken());
			$curl->get(
				static::$githubPoint . '/users/' . $id,
				[
				]
			);
			$response = $curl->response;

			if ($curl->http_status_code !== 200) {
				throw new \Exception(isset($response->message) ? $response->message : 'Unknown error');
			}
			$user = $response;
			//$user->contributions = static::getGithubUserContribotions($id);

			static::$cache->set('github-user-info', $user);
		}
		return $user;
	}

	public static function getGithubUserContribotions($id)
	{
		$tags = static::$cache->get('github-user-contributions');
		if ($tags === false) {
			$curl = new Curl();
			$curl->setHeader('Accept', 'application/vnd.github.v3+json');
			$curl->setHeader('Authorization', 'token ' . static::getGithubToken());
			$curl->get(
				static::$githubPoint . '/users/' . $id . '/repos',
				[
				]
			);
			$response = $curl->response;

			if ($curl->http_status_code !== 200) {
				throw new \Exception(isset($response->message) ? $response->message : 'Unknown error');
			}

			static::$cache->set('github-user-contributions', false);
		}
		return false;
	}

	public static function getGithubLoginLink()
	{
		$params = [
			'client_id' => GITHUB_CLIENT_ID,
			'redirect_uri' => GITHUB_REDIRECT_URL,
		];
		return 'https://github.com/login/oauth/authorize?' . http_build_query($params);
	}

	/**
	 * @return bool
	 */
	public static function hasValidGithubToken()
	{
		if (isset($_SESSION['github_token']) && $_SESSION['github_token']) {
			return true;
		}
		return false;
	}

	public static function getGithubAccessToken($code)
	{
		$curl = new Curl();
		$curl->setHeader('Accept', 'application/json');
		$curl->post(
			'https://github.com/login/oauth/access_token',
			[
				'client_id' => GITHUB_CLIENT_ID,
				'client_secret' => GITHUB_CLIENT_SECRET,
				'code' => $code,
				'redirect_uri' => GITHUB_REDIRECT_URL,
			]
		);

		$response = $curl->response;
		if ($curl->http_status_code !== 200) {
			throw new \Exception(isset($response->message) ? $response->message : 'Unknown error');
		}
		var_dump($response);
		$token = $response->access_token;
		$tokenType = $response->token_type;
		static::setGithubTokenAndExpire($token, $tokenType);
	}

	public static function setGithubTokenAndExpire($token, $tokenType)
	{
		$_SESSION['github_token'] = $token;
		$_SESSION['github_token_type'] = $tokenType;
	}

	public static function getGithubToken()
	{
		if (!static::hasValidGithubToken()) {
			throw new \Exception('You have no access token! Please, go to index page and take access tokens');
		}
		return $_SESSION['github_token'];
	}
} 
