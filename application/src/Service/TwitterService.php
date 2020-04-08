<?php
namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Log\Log;
use phpDocumentor\Reflection\Types\String_;


class TwitterService
{
    /**
     * @var TwitterOAuth $connection
     */
    protected $connection;

    /**
     * @var \stdClass $content
     */
    protected $content;

    /**
     * @var array $searchOptions;
     */
    protected $searchOptions;

    public function __construct()
    {
        try{
            $this->setConnection();
            $this->content = $this->connection->get("account/verify_credentials");
            $this->searchOptions = [
                'count' => Configure::read('App.searchMax'),
                'exclude_replies' => true,
                'include_entities' => false,
                'result_type' => 'recent'
            ];

        } catch (\Exception $ex) {
            Log::alert($ex->getMessage());
        }
    }

    /**
     * @param string $search
     * @return array
     */
    public function fetchTweets($search)
    {
        $this->searchOptions += ['q' => $search];
        $data = $this->connection->get('search/tweets', $this->searchOptions);

        $tweets = [];
        if (isset($data)) {
            foreach ($data->statuses as $tweet) {
                $tweets[] = ['text' => $tweet->text, 'by' => $tweet->user->screen_name];
            }
        }

        return $tweets;
    }

    protected function setConnection(): void
    {
        $this->connection = new TwitterOAuth(
            Configure::read('TwitterApi.apiKey'),
            Configure::read('TwitterApi.apiSecretKey'),
            Configure::read('TwitterApi.accessToken'),
            Configure::read('TwitterApi.accessTokenSecret')
        );
    }
}