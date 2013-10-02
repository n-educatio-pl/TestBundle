<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\Awaiter;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter
 */
class AwaiterTest extends \PHPUnit_Framework_TestCase
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
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter', $this->getAwaiter());
  }

  /**
   * Do sth.
   *
   * @return Awaiter
   */
  private function getAwaiter()
  {
    return new Awaiter();
  }
}