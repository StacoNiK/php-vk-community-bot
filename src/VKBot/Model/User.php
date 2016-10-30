<?php namespace VKBot\Model;

use \VKApi\VkRequest;
use \VKApi\VkParams;

class User
{
	protected $user_info = [];

	public function __construct($user_id = 0)
	{
		if ($user_id > 0) {
			$this->load($user_id);
		}
	}

	public function load($user_id)
	{
		if ($user_id < 1) {
			return false;
		}
		$params = new VkParams(['user_ids' => $user_id, 'fields' => 'photo_id, verified, sex, bdate, city, country, home_town, has_photo, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, online, lists, domain, has_mobile, contacts, site, education, universities, schools, status, last_seen, followers_count, common_count, occupation, nickname, relatives, relation, personal, connections, exports, wall_comments, activities, interests, music, movies, tv, books, games, about, quotes, can_post, can_see_all_posts, can_see_audio, can_write_private_message, can_send_friend_request, is_favorite, is_hidden_from_feed, timezone, screen_name, maiden_name, crop_photo, is_friend, friend_status, career, military']);
		$request = new VkRequest('users.get', $params);
		$result = $request->execute();
		if ($result->is_success) {
			$this->user_info = $result->response->get()[0];
			return true;
		} 
		return false;
	}

	public function getInfo()
	{
		return $this->user_info;
	}

	public function getName()
	{
		return $this->get('first_name');
	}

	public function getFullName()
	{
		return $this->get('first_name').' '.$this->get('last_name');
	}

	public function get($key)
	{
		if (array_key_exists($key, $this->user_info)) {
			return $this->user_info[$key];
		} else {
			return false;
		}
	} 
}