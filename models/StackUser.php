<?php
/**
 * Author: metal
 * Email: metal
 */

namespace metalguardian\models;

/**
 * Class StackUser
 * @package metalguardian\models
 *
 * @property $badge_counts [bronze, silver, gold]
 * @property $account_id
 * @property $is_employee
 * @property $last_modified_date
 * @property $last_access_date
 * @property $reputation_change_year
 * @property $reputation_change_quarter
 * @property $reputation_change_month
 * @property $reputation_change_week
 * @property $reputation_change_day
 * @property $reputation
 * @property $creation_date
 * @property $user_type
 * @property $user_id
 * @property $age
 * @property $accept_rate
 * @property $location
 * @property $website_url
 * @property $link
 * @property $display_name
 * @property $profile_image
 *
 * @property StackUserTag[] $tags [count, name]
 * @property StackUserTopTag[] $topTags [count, name]
 */
class StackUser
{
	/**
	 * @param StackUser $user
	 *
	 * @return array
	 */
	public static function createChartTags($user)
	{
		$labels = [];
		$data = [];
		foreach ($user->tags as $tag) {
			$labels[] = $tag->name;
			$data[] = $tag->count;
		}
		return [$labels, $data];
	}

	/**
	 * @param StackUser $user
	 *
	 * @return array
	 */
	public static function createChartTopTags($user)
	{
		$labels = [];
		$answerCount = [];
		$answerScore = [];
		$questionCount = [];
		$questionScore = [];
		foreach ($user->topTags as $tag) {
			$labels[] = $tag->tag_name;
			$answerCount[] = $tag->answer_count;
			$answerScore[] = $tag->answer_score;
			$questionCount[] = $tag->question_count;
			$questionScore[] = $tag->question_score;
		}
		return [$labels, $answerCount, $answerScore, $questionCount, $questionScore];
	}

} 
