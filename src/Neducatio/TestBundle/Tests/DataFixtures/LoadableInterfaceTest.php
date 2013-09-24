<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\LoadableInterface
 */
class LoadableInterfaceTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }
  /**
   * Do sth.
   * 
   * @test
   */
  public function shouldBeAbleToIncjectContainer()
  {
    $loadable = m::mock('\Neducatio\TestBundle\DataFixtures\LoadableInterface');
    $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerAwareInterface', $loadable);
  }
}
