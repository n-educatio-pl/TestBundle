<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\ConditionNotFulfilledException;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\ConditionNotFulfilledException
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
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\ConditionNotFulfilledException', new ConditionNotFulfilledException());
  }
}