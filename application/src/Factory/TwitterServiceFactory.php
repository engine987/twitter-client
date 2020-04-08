<?php
/**
 *  * Created by PhpStorm.
 * User: Krishna Rao
 * Date: 2020-04-07
 * Time: 13:10
 */

namespace App\Factory;


use App\Service\TwitterService;

class TwitterServiceFactory
{
    /**
     * @return TwitterService
     */
    public function getTwitterService() {
        return new TwitterService();
    }
}