<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker;
use Mockery as m;

/**
 * Fixture Dependency Invoker
 *
 * @covers Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker
 */
class FixtureDependencyInvokerTest extends \PHPUnit_Framework_TestCase
{
  private $dependencyInvoker;

  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->dependencyInvoker = new FixtureDependencyInvoker();
  }

  /**
   * Tears down Mockery
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
    $expectedFDIClass = 'Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker';
    $this->assertInstanceOf($expectedFDIClass, $this->dependencyInvoker);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getExecutor_shouldReturnInstanceOfExecutor()
  {
    $expectedExecutorClass = 'Doctrine\Common\DataFixtures\Executor\ORMExecutor';
    $this->assertInstanceOf($expectedExecutorClass, $this->dependencyInvoker->getExecutor());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getFixtureExecutor_shouldReturnInstanceOfFixtureExecutor()
  {
    $expectedFixtureExecutorClass = 'Neducatio\TestBundle\DataFixtures\FixtureExecutor';
    $this->assertInstanceOf($expectedFixtureExecutorClass, $this->dependencyInvoker->getFixtureExecutor());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getEntityManager_shouldReturnInstanceOfEntityManager()
  {
    $expectedOMClass = 'Doctrine\Common\Persistence\ObjectManager';
    $this->assertInstanceOf($expectedOMClass, $this->dependencyInvoker->getEntityManager());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getComponentBuilder_shouldReturnInstanceOfComponentBuilder()
  {
    $expectedCBClass = 'Neducatio\TestBundle\DataFixtures\ComponentBuilder';
    $this->assertInstanceOf($expectedCBClass, $this->dependencyInvoker->getComponentBuilder());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getUniqueDependencyResolver_shouldReturnInstanceOfUniqueDependencyResolver()
  {
    $expectedUDRClass = 'Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver';
    $this->assertInstanceOf($expectedUDRClass, $this->dependencyInvoker->getUniqueDependencyResolver());
  }
}