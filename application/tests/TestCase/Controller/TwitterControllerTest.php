<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TwitterController;
use App\Factory\TwitterServiceFactory;
use App\Service\TwitterService;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TwitterController Test Case
 *
 * @uses \App\Controller\TwitterController
 */
class TwitterControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $route;

    public function setUp()
    {
        parent::setUp();
        $this->route = ['controller' => 'twitter', 'action' => 'get-tweets'];
    }

    public function testGetTweets()
    {
        $this->get($this->route);
        $this->assertResponseCode(200);
        $this->assertResponseContains('Search for tweets');

        $serviceFactory = Configure::read('twitterFactory');

        $tweets = [
            ['by' => 'SillyBilly',  'text' => 'My horse has green hair'],
            ['my' => 'DonaldTrump', 'text' => 'I have the best words'],
        ];

        $serviceMock = $this->getMockBuilder(TwitterService::class)
            ->disableOriginalConstructor()
            ->setMethods(['fetchTweets'])
            ->getMock();

        $serviceMock
            ->expects($this->once())
            ->method('fetchTweets')
            ->willReturn($tweets);

        $serviceFactoryMock = $this->getMockBuilder(TwitterServiceFactory::class)
            ->setMethods(['getTwitterService'])
            ->getMock();

        $serviceFactoryMock
            ->expects($this->once())
            ->method('getTwitterService')
            ->willReturn($serviceMock);

        Configure::write('twitterFactory', $serviceFactoryMock);
        $data = ['search' => '#sillytweets'];
        $this->enableCsrfToken();
        $this->post($this->route, $data);

        $this->assertResponseCode(200);
        $this->assertResponseContains('Search for tweets');

        //Set it back !!!
        Configure::write('twitterFactory', $serviceFactory);

    }

}
