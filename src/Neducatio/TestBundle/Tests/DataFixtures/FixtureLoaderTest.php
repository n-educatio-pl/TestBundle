<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\FixtureLoader;
use Mockery as m;

/**
 * Fixture Loader Test
 *
 * @cover Neducatio\TestBundle\DataFixtures\FixtureLoader
 */
class FixtureLoaderTest extends \PHPUnit_Framework_TestCase
{
  protected $invoker;

  /**
   * Tears down Mockery
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->invoker = $this->getFixtureDependencyInvoker();
    $this->invoker->shouldReceive('getComponentBuilder')->andReturn($this->getComponentBuilder())->byDefault();
    $this->invoker->shouldReceive('getUniqueDependencyResolver')->andReturn($this->getUniqueDependencyResolver())->byDefault();
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->invoker->shouldReceive('getComponentBuilder')->andReturn($this->getComponentBuilder())->once();
    $this->invoker->shouldReceive('getUniqueDependencyResolver')->andReturn($this->getUniqueDependencyResolver())->once();
    $this->assertInstanceOf('Neducatio\TestBundle\DataFixtures\FixtureLoader', $this->getFixtureLoader());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function load_emptyArrayPassed_shouldEraseReferencesAndExecuteFixtures()
  {
    $this->invoker->shouldReceive('getFixtureExecutor')->andReturn($this->getFixtureExecutor())->once();
    $this->invoker->shouldReceive('getExecutor')->andReturn($this->getExecutor('someKey', 'someReference'))->once();
    $this->invoker->shouldReceive('getEntityManager')->andReturn($this->getEntityManager())->once();

    $this->getFixtureLoader()->load();
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getReference_someReferenceKey_shouldCallForReferenceExecutor()
  {
    $this->invoker->shouldReceive('getExecutor')->andReturn($this->getExecutor('referenceKey', 'referenceObject'));
    $reference = $this->getFixtureLoader()->getReference('referenceKey');
    $this->assertSame('referenceObject', $reference);
  }

  /**
   * Do sth.
   *
   * @test
   *
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage does not exist
   */
  public function getReference_referenceKeyDoesNOTExist_shouldThrowException()
  {
    $this->invoker->shouldReceive('getExecutor')->andReturn($this->getExecutor('referenceKey', 'referenceObject'));
    $this->getFixtureLoader()->getReference('nonExistingKey');
  }

  private function getComponentBuilder()
  {
    $component = m::mock('Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');

    $componentBuilder = m::mock('Neducatio\TestBundle\DataFixtures\ComponentBuilder');
    $componentBuilder->shouldReceive('buildFromArray')->andReturn($component);

    return $componentBuilder;
  }

  private function getUniqueDependencyResolver()
  {
    $uniqueDependencyResolver = m::mock('Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver');
    $uniqueDependencyResolver->shouldReceive('resolve')->andReturn(array());

    return $uniqueDependencyResolver;
  }

  private function getExecutor($key, $reference)
  {
    $referenceRepository = m::mock('\stdClass');
    $referenceRepository->shouldReceive('hasReference')->byDefault();
    $referenceRepository->shouldReceive('hasReference')->with('nonExistingKey')->andReturn(false);
    $referenceRepository->shouldReceive('hasReference')->with($key)->andReturn(true);
    $referenceRepository->shouldReceive('getReference')->with($key)->andReturn($reference);
    $referenceRepository->shouldReceive('getReference')->with('nonExistingKey')->never();


    $executor = m::mock('Doctrine\Common\DataFixtures\Executor\ORMExecutor');
    $executor->shouldReceive('setReferenceRepository');
    $executor->shouldReceive('getReferenceRepository')->andReturn($referenceRepository);

    return $executor;
  }

  private function getEntityManager()
  {
    return m::mock('Doctrine\Common\Persistence\ObjectManager');
  }

  private function getFixtureExecutor()
  {
    $fixtureExecutor = m::mock('Neducatio\TestBundle\DataFixtures\FixtureExecutor');
    $fixtureExecutor->shouldReceive('execute');

    return $fixtureExecutor;
  }

  private function getFixtureDependencyInvoker()
  {
    return m::mock('Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker');
  }

  private function getFixtureLoader(array $fixtureClasses = array())
  {
    return new FixtureLoader($this->invoker, $fixtureClasses);
  }
}

