<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\BondingComponent;
use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\BondingComponent
 */
class BondingComponentTest extends \PHPUnit_Framework_TestCase
{
  private $component;

  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->component = new BondingComponent();
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
  public function __construct_shouldCreateInstance()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\BondingComponent', $this->component);
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface', $this->component);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getId_shouldReturnNull()
  {
    $this->assertNull($this->component->getId());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getChildren_noChildren_shouldReturnEmptyArray()
  {
    $this->assertSame(array(), $this->component->getChildren());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function add_someComponentsPassed_shouldAddToChildren()
  {
    $componentA = $this->fixture = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $componentB = $this->fixture = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $componentC = $this->fixture = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $this->component->add($componentA);
    $this->component->add($componentB);
    $this->component->add($componentC);
    $this->assertSame(array($componentA, $componentB, $componentC), $this->component->getChildren());
  }
}
