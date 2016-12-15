<?php
namespace SlackLogEngine\Test\TestCase\Log\Engine;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Exception;
use Maknz\Slack\Client as SlackClient;

use SlackLogEngine\Log\Engine\SlackLogEngine;

class TestException extends Exception
{
}

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
            ['send']
        );
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

        // test invalid and setClient()
        $this->SlackLogEngine = new SlackLogEngine([
            'scopes' => [],
            'levels' => ['error']
        ]);
        $this->assertFalse($this->SlackLogEngine->log('test', 'error'));
        $this->client = $this->getMockBuilder('\Maknz\Slack\Client')
            ->setMethods(['send'])
            ->setConstructorArgs(['http://example.com'])
            ->getMock();
        $this->client->expects($this->once())
            ->method('send');
        $this->SlackLogEngine->setClient($this->client);
        $result = $this->SlackLogEngine->log('test', 'error');
        $this->assertTrue($result);

        // test exception
        $this->client = $this->getMockBuilder('\Maknz\Slack\Client')
            ->setMethods(['send'])
            ->setConstructorArgs(['http://example.com'])
            ->getMock();
        $this->SlackLogEngine = new SlackLogEngine([
            'client' => $this->client,
            'scopes' => [],
            'levels' => ['error']
        ]);
        Configure::write('debug', false);
        $this->client->expects($this->once())
            ->method('send')
            ->will($this->throwException(new Exception));
        $result = $this->SlackLogEngine->log('test', 'error');
        $this->assertFalse($result);

        // test exception on debug mode
        $this->client = $this->getMockBuilder('\Maknz\Slack\Client')
            ->setMethods(['send'])
            ->setConstructorArgs(['http://example.com'])
            ->getMock();
        $this->SlackLogEngine = new SlackLogEngine([
            'client' => $this->client,
            'scopes' => [],
            'levels' => ['error']
        ]);
        Configure::write('debug', true);
        $this->client->expects($this->once())
            ->method('send')
            ->will($this->throwException(new TestException('testException')));
        try {
            $this->SlackLogEngine->log('test', 'error');
            $this->fail('Expected exception was not thrown');
        } catch (TestException $e) {
            $this->assertSame('testException', $e->getMessage());
        }
    }
}
