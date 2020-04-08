<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Factory\TwitterServiceFactory;
use App\Service\TwitterService;
use Cake\Core\Configure;

/**
 * Twitter Controller
 *
 */
class TwitterController extends AppController
{
    /**
     * Get method
     *
     * @return \Cake\Http\Response|null
     */
    public function getTweets()
    {
        if ($this->request->getMethod() == 'POST') {
            if ($this->request->getData('search')) {
                $factory = Configure::read('twitterFactory');

                /** @var TwitterService $service */
                $service = $factory->getTwitterService();

                /** * @var array $tweets */
                $tweets = $service->fetchTweets($this->request->getData('search'));

                $this->set(compact('tweets'));
            }
        }
    }
}
