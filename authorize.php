<?php

require 'vendor/autoload.php';
require 'twitter.conf';
use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'oob'));

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

echo "Go to this URL in the browser to complete authorization:\n";
echo $url . "\n\n";

echo "Enter pin here: ";
$handle = fopen ("php://stdin","r");
$pin = fgets($handle);

$result = $connection->oauth('oauth/access_token', array('oauth_verifier' => $pin, 'oauth_token' => $request_token['oauth_token']));

print_r($result);
