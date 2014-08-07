<?php 

namespace League\OAuth1\Client\Server;

use League\OAuth1\Client\Credentials\TokenCredentials;

class Discogs extends Server
{

    public function urlTemporaryCredentials()
    {
        return 'http://api.discogs.com/oauth/request_token';
    }

    public function urlAuthorization()
    {
        return 'http://discogs.com/oauth/authorize';
    }

    public function urlTokenCredentials()
    {
        return 'http://api.discogs.com/oauth/access_token';
    }

    public function userDetails($data, TokenCredentials $tokenCredentials) {}
    public function userUid($data, TokenCredentials $tokenCredentials) {}
    public function userEmail($data, TokenCredentials $tokenCredentials) {}
    public function userScreenName($data, TokenCredentials $tokenCredentials) {}
    public function urlUserDetails() {}

}

?>