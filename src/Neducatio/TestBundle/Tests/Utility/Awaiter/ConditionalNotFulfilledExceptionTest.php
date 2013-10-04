<?php

namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException
 */
class ConditionNotFulfilledExceptionTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Tests constructor
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException', new ConditionNotFulfilledException());
  }
}