<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\WebClientRetriever;
use Mockery as m;

/**
 * TestClientRetriever
 *
 * @covers Neducatio\TestBundle\Utility\WebClientRetriever
 */
class WebClientRetrieverTest extends \PHPUnit_Framework_TestCase
{
  private $client;
  private $container;
  private $userReference;
  private $clientRetriever;
  private $form;

  const USER_NAME = 'barbra.rookie@example.com';

  /**
   * Test for constructor
   *
   * @test
   */
  public function assertInstanceOfWebClientRetriever()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\WebClientRetriever', $this->clientRetriever);
  }

  /**
   * Test for setClient
   *
   * @test
   */
  public function shouldSetClient()
  {
    $result = $this->clientRetriever->setClient($this->userReference);

    $this->assertEquals($this->client, $result);
  }

  /**
   * Prepares mocks.
   */
  public function setUp()
  {
    $this->form = m::mock('Symfony\Component\DomCrawler\Form');
    $this->client = $this->getWebClientMock();
    $this->userReference = m::mock('FOS\UserBundle\Entity\User');
    $this->userReference->shouldReceive('getUsername')->andReturn(self::USER_NAME);
    $this->container = $this->getContainerMock();
    $this->clientRetriever = new WebClientRetriever($this->container);
  }

  /**
   * Tears down.
   */
  public function tearDown()
  {
    m::close();
  }

  private function getCrawlerMock()
  {
    $crawlerWithFilteredListOfNodes = m::mock('stdClass');
    $crawlerWithFilteredListOfNodes->shouldReceive('form')->andReturn($this->form);

    $crawler = m::mock('Symfony\Component\DomCrawler\Crawler');
    $crawler->shouldReceive('selectButton')->with('_submit')->andReturn($crawlerWithFilteredListOfNodes);

    return $crawler;
  }

  private function getWebClientMock()
  {
    $client = m::mock('Symfony\Bundle\FrameworkBundle\Client');
    $client->shouldReceive('request')->with('GET', '/login')->andReturn($this->getCrawlerMock());
    $client->shouldReceive('submit')->with($this->form, array('_username' => self::USER_NAME, '_password' => 'test'));

    return $client;
  }

  private function getContainerMock()
  {
    $container = m::mock('Symfony\Component\DependencyInjection\Container');
    $container->shouldReceive('get')->with('test.client')->andReturn($this->client);

    return $container;
  }
}
