<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\Registry;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Registry
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
  private $registry;
  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->registry = new Registry();
  }

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
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Registry', $this->registry);
  }

  /**
   * @test
   */
  public function get_propertyNotSet_schouldReturnDefaultValue()
  {
    $this->assertSame(15, $this->registry->get("nonexisting", 15));
  }

  /**
   * @test
   */
  public function get_propertyNotSetDefaultNotPassed_schouldReturnDefaultDefaultValue()
  {
    $this->assertNull($this->registry->get("nonexisting"));
  }

  /**
   * @test
   */
  public function get_propertySet_schouldReturnStoredValue()
  {
    $this->registry->set("somekey", "something");
    $this->assertSame("something", $this->registry->get("somekey"));
  }

  /**
   * @test
   */
  public function set_propertySetTwice_schouldReturnLastStoredValue()
  {
    $storedObject = new \StdClass();
    $storedObject->id = "newobject";
    $this->registry->set("someotherkey", "something");
    $this->registry->set("someotherkey", $storedObject);
    $this->assertSame($storedObject, $this->registry->get("someotherkey"));
  }
}