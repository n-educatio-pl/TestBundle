<?php

namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\TraversableElementNotSetException;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter\TraversableElementNotSetException
 */
class TraversableElementNotSetExceptionTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Tests constructor
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\TraversableElementNotSetException', new TraversableElementNotSetException());
  }
}