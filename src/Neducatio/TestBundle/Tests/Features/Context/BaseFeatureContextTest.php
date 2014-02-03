<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use Neducatio\TestBundle\Tests\Features\Context\FakeContext\TestableBaseFeatureContext;
use Mockery as m;

/**
 * Tests
 *
 * @covers Neducatio\TestBundle\Features\Context\BaseFeatureContext
 */
class BaseFeatureContextTest extends \PHPUnit_Framework_TestCase
{
  private $feature;

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->feature = new TestableBaseFeatureContext(array());
  }

  /**
   * Tear down
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
    $this->assertInstanceOf('Neducatio\TestBundle\Features\Context\BaseFeatureContext', $this->feature);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getRegistry_shouldReturnRegistryObject()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Registry', $this->feature->getRegistry());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function setKernel_calledWithMock_shouldSetMockAsKernel()
  {
    $this->feature->setKernel($this->getKernelMock());
    $this->assertInstanceOf('Symfony\Component\HttpKernel\KernelInterface', $this->feature->kernel);
    $this->assertInstanceOf('Behat\Symfony2Extension\Context\KernelAwareInterface', $this->feature);
  }

  /**
   * @test
   *
   * @expectedException RuntimeException
   * @expectedExceptionMessage Fixtures are not loaded
   */
  public function getReference_fixturesNotLoaded_shouldThrowRuntimeException()
  {
    $this->feature->getReference('ref');
  }

  /**
   * @test
   *
   */
  public function getReference_fixtureLoaded_shouldReturnReferenceToThatFixture()
  {
    $fixtures = array(
      \Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\TestableFixture::NAME,
    );
    $this->configureDependencies();
    $this->feature->dependencies->getExecutor()->getReferenceRepository()->shouldReceive('hasReference')->with('foo')->andReturn(true);
    $this->feature->dependencies->getExecutor()->getReferenceRepository()->shouldReceive('getReference')->with('foo')->andReturn('bar');
    $this->feature->loadFixtures($fixtures);
    $this->assertEquals('bar', $this->feature->getReference('foo'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function usingJs_called_shouldReturnFalse()
  {
    $this->assertFalse($this->feature->usingJs());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function usingJs_calledAfterEnablingJs_shouldReturnTrue()
  {
    $this->feature->enableJs();
    $this->assertTrue($this->feature->usingJs());
  }

  private function getKernelMock()
  {
    $container = m::mock('stdClass');
    $kernel = m::mock('Symfony\Component\HttpKernel\KernelInterface');
    $kernel->shouldReceive('getContainer')->andReturn($container);

    return $kernel;
  }

  protected function configureDependencies()
  {
    $bondingComponent = m::mock('Neducatio\TestBundle\DataFixtures\BondingComponent');
    $componentBuilder = m::mock('Neducatio\TestBundle\DataFixtures\ComponentBuilder');
    $componentBuilder->shouldReceive('buildFromArray')->andReturn($bondingComponent);
    $this->feature->dependencies = m::mock('Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker');
    $this->feature->dependencies->shouldReceive('getComponentBuilder')->andReturn($componentBuilder);
    $em = m::mock('Doctrine\ORM\EntityManager');
    $this->feature->dependencies->shouldReceive('getEntityManager')->andReturn($em);
    $fixtureExecutor = m::mock('Neducatio\TestBundle\DataFixtures\FixtureExecutor');
    $fixtureExecutor->shouldReceive('execute')->byDefault();
    $this->feature->dependencies->shouldReceive('getFixtureExecutor')->andReturn($fixtureExecutor);
    $executor = m::mock('Doctrine\Common\DataFixtures\Executor\ORMExecutor');
    $executor->shouldReceive('setReferenceRepository')->byDefault();
    $referenceRepository = m::mock('Doctrine\Common\DataFixtures\ReferenceRepository');
    $executor->shouldReceive('getReferenceRepository')->andReturn($referenceRepository);
    $this->feature->dependencies->shouldReceive('getExecutor')->andReturn($executor);
    $uniqueDependencyResolver = m::mock('Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver');
    $uniqueDependencyResolver->shouldReceive('resolve')->andReturn(array());
    $this->feature->dependencies->shouldReceive('getUniqueDependencyResolver')->andReturn($uniqueDependencyResolver);
  }
}
