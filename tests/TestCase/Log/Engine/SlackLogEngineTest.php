<?php
namespace SlackLogEngine\Test\TestCase\Log\Engine;

use Cake\TestSuite\TestCase;
use Maknz\Slack\Client as SlackClient;

use SlackLogEngine\Log\Engine\SlackLogEngine;

class SlackLogEngineTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SlackLogEngine\Log\Engine\SlackLogEngine
     */
    public $SlackLogEngine;

    /**
     * Mock slack client
     *
     * @var \Maknz\Slack\Client
     */
    public $client;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->client = null;
        $this->SlackLogEngine = null;
    }

    /**
     * Test log method
     *
     * @test
     */
    public function log()
    {
        // test client option
        $this->client = $this->getMockBuilder('\Maknz\Slack\Client')
            ->setMethods(['send'])
            ->setConstructorArgs(['http://example.com'])
            ->getMock();
        $this->SlackLogEngine = new SlackLogEngine([
            'client' => $this->client,
            'scopes' => [],
            'levels' => ['error']
        ]);

        $this->client->expects($this->once())
            ->method('send');
        $result = $this->SlackLogEngine->log('test', 'error');
        $this->assertTrue($result);

        // test hookUrl option
        $clientClass = $this->getMockClass(
            '\Maknz\Slack\Client',
            ['send']);
        $this->SlackLogEngine = new SlackLogEngine([
            'hookUrl' => 'http://example.com',
            'clientClass' => $clientClass,
            'scopes' => [],
            'levels' => ['error']
        ]);
        $this->client = $this->SlackLogEngine->getClient();
        $this->client->expects($this->once())
            ->method('send');
        $result = $this->SlackLogEngine->log('test', 'error');
        $this->assertTrue($result);
    }

}