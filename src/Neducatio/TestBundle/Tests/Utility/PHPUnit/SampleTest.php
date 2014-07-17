<?php

namespace Neducatio\TestBundle\Tests\Utility\PHPUnit;

/**
 * Sample test for PHPUnitRunner tests
 */
class SampleTest extends \PHPUnit_Framework_TestCase
{
  static private $callStack = array();

  /**
   * Construct
   *
   * @param type  $name     Name
   * @param array $data     Data
   * @param type  $dataName DataName
   */
  public function __construct($name = null, array $data = array(), $dataName = '')
  {
    static::$callStack = array();
    parent::__construct($name, $data, $dataName);
  }

  /**
   * @test
   */
  public function checkIfTrueEqualsTrue()
  {
    static::$callStack[] = 'test';
    $this->assertTrue(true);
  }

  /**
   * Set up
   */
  public function setUp()
  {
    static::$callStack[] = 'setUp';
  }

  /**
   * Tear down
   */
  public function tearDown()
  {
    static::$callStack[] = 'tearDown';
  }

  /**
   * Set up before class
   */
  static public function setUpBeforeClass()
  {
    static::$callStack[] = 'setUpBeforeClass';
  }

  /**
   * Tear down
   */
  static public function tearDownAfterClass()
  {
    static::$callStack[] = 'tearDownAfterClass';
  }

  /**
   * Get call stack
   *
   * @return array
   */
  public function getCallStack()
  {
    return static::$callStack;
  }
}

