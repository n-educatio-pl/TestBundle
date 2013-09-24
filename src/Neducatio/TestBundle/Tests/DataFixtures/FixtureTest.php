<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\TestableFixture;

use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\Fixture
 * @covers Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\TestableFixture
 */
class FixtureTest extends \PHPUnit_Framework_TestCase
{
  private $fixture;
  /**
   * Do sth.
   *
   */
  public function setUp()
  {
    $this->fixture = new TestableFixture();
    $this->container = m::mock('\Symfony\Component\DependencyInjection\ContainerInterface');
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
  public function __construct_shouldCreateInstanceOfFixture()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\Fixture', $this->fixture);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOfLoadableInterfaceFixture()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\LoadableInterface', $this->fixture);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function setContainer_someContainerPassed_shouldStoreThisContainer()
  {
    $this->fixture->setContainer($this->container);
    $this->assertSame($this->container, $this->fixture->getContainer());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function getDependentClasses_noDependencies_shouldReturnEmptyArray()
  {
    $this->fixture->dependentClasses = array();
    $this->assertSame(array(), $this->fixture->getDependentClasses());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function getDependentClasses_someDependencies_shouldReturnArrayOfDependentClasses()
  {
    $this->fixture->dependentClasses = array('foo', 'bar');
    $this->assertSame(array('foo', 'bar'), $this->fixture->getDependentClasses());
  }
}
