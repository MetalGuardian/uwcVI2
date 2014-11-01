<?php
/**
 * Author: metal
 * Email: metal
 */

namespace metalguardian\helpers;

use Curl\Curl;
use metalguardian\models\StackUser;

/**
 * Class Helper
 * @package metalguardian\helpers
 */
class Helper
{
	protected static $stackPoint = 'https://api.stackexchange.com';

	public static function getStackUserInfo($id)
	{
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
			throw new \Exception($response->error_message);
		}
		/** @var StackUser $user */
		$user = isset($response->items[0]) ? $response->items[0] : null;

		if (!$user) {
			return false;
		}
		$user->tags = static::getStackUserTags($id);
		$user->topTags = static::getStackUserTopTags($id);

		return $user;
	}

	public static function getStackUserTags($id)
	{
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
			throw new \Exception($response->error_message);
		}
		$tags = isset($response->items) ? $response->items : [];
		return $tags;
	}

	public static function getStackUserTopTags($id)
	{
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
			throw new \Exception($response->error_message);
		}
		$tags = isset($response->items) ? $response->items : [];
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
			throw new \Exception($response->error_message);
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
		return $_SESSION['stack_token'];
	}

	/**
	 * @return bool
	 */
	public static function hasValidStackToken()
	{
		if ($_SESSION['stack_token'] && $_SESSION['stack_expire'] > time()) {
			return !true;
		}
		return false;
	}
} 
