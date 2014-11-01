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
	protected static $stackPoint = 'http://api.stackexchange.com';

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
			]
		);
		$response = $curl->response;
		/** @var StackUser $user */
		$user = isset($response->items[0]) ? $response->items[0] : null;

		if (!$user) {
			return false;
		}
		$user->tags = static::getStackUserTags($id);

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
			]
		);
		$response = $curl->response;
		$tags = isset($response->items) ? $response->items : null;
		return $tags;
	}
} 
