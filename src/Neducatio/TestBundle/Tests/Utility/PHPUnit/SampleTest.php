<?php

namespace Neducatio\TestBundle\Tests\Utility\PHPUnit;

/**
 * Sample test for PHPUnitRunner tests
 */
class SampleTest extends \PHPUnit_Framework_TestCase
{
  private $callStack = array();

  /**
   * @test
   */
  public function checkIfTrueEqualsTrue()
  {
    $this->callStack[] = 'test';
    $this->assertTrue(true);
  }

  /**
   * Set up
   */
  public function setUp()
  {
    $this->callStack[] = 'setUp';
  }

  /**
   * Tear down
   */
  public function tearDown()
  {
    $this->callStack[] = 'tearDown';
  }

  /**
   * Get call stack
   *
   * @return array
   */
  public function getCallStack()
  {
    return $this->callStack;
  }
}

