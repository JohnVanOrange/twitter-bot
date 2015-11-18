<?php

require 'vendor/autoload.php';
require 'twitter.conf';
require 'user.conf';
require 'site.conf';
use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
$db = new SQLite3(__DIR__ . '/imagelog.db');
$likes = json_decode(file_get_contents(SITE_URL . '/api/image/recentLikes'), TRUE);

foreach ($likes as $like) {
	$lookup_sql = "SELECT image FROM imagelog WHERE image = '" . $like['uid'] . "';";
	$result = $db->query($lookup_sql);
	if (!$result->fetchArray()[0]) {
		$update = $connection->post("statuses/update", array("status" => $like['page_url']));
		$insert_sql = "INSERT INTO imagelog (image) VALUES ('" . $like['uid'] . "');";
		$db->query($insert_sql);
		break;
	}
}

echo "script complete\n\n";
