<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\FixtureComponent;
use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\FixtureComponent
 */
class FixtureComponentTest extends \PHPUnit_Framework_TestCase
{
  private $component;
  private $fixture;
  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->fixture = m::mock('\Neducatio\TestBundle\DataFixtures\LoadableInterface');
    $this->component = new FixtureComponent($this->fixture);
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
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\FixtureComponent', $this->component);
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface', $this->component);
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\FixtureComponentInterface', $this->component);
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Id must be set
   */
  public function getId_noIdSet_shouldThrowException()
  {
    $this->component->getId();
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function setId_someIdPassed_shouldStoreThisId()
  {
    $fakeId = "foo";
    $this->component->setId($fakeId);
    $this->assertSame($fakeId, $this->component->getId());
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
  public function setChildren_someArrayPassed_shouldStoreThisArray()
  {
    $fakeChildren = array('a', 'b');
    $this->component->setChildren($fakeChildren);
    $this->assertSame($fakeChildren, $this->component->getChildren());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function getFixture_fixturePassedInConstructor_shouldReturnThisFixture()
  {
    $this->assertSame($this->fixture, $this->component->getFixture());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function add_someComponentsPassed_shouldAddToChildren()
  {
    $componentA = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $componentB = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $componentC = m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $this->component->add($componentA);
    $this->component->add($componentB);
    $this->component->add($componentC);
    $this->assertSame(array($componentA, $componentB, $componentC), $this->component->getChildren());
  }
}
