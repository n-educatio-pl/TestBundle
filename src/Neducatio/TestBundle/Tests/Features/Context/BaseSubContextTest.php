<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use Neducatio\TestBundle\Tests\Features\Context\FakeContext\TestableBaseSubContext;

use Mockery as m;

/**
 * Tests
 *
 * @covers Neducatio\TestBundle\Features\Context\BaseSubContext
 */
class BaseSubContextTest extends SubContextTestCase
{
  private $translator;
  private $feature;

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->translator = m::mock('Symfony\Bundle\FrameworkBundle\Translation\Translator');
    $builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $builder->shouldReceive('build')->andReturn('page');
    $this->feature = new TestableBaseSubContext(array('builder' => $builder));
  }

  /**
   * Construct test
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Features\Context\BaseSubContext', $this->feature);
  }

  /**
   * get & set Page test
   *
   * @test
   */
  public function getPage_pageIsSet_shouldReturnGivenPage()
  {
    $this->feature->setParentContext($this->getParentContextMock());
    $this->feature->setPage('page');
    $this->assertSame('page', $this->feature->getPage());
  }

  /**
   * @test
   */
  public function translate_shouldCallTransMethodOnTranslator()
  {
    $this->translator->shouldReceive('trans')->with('messageToTrans', array(), 'messages', 'pl')->once();
    $this->feature->setKernel($this->getKernelMock());
    $this->feature->translate('messageToTrans');
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
   * Do sth.
   *
   * @test
   * @expectedException RuntimeException
   * @expectedExceptionMessage Sub context has no parent
   */
  public function loadFixtures_contextWithoutParent_shouldThrowException()
  {
    $this->feature->loadFixtures(array());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function loadFixtures_contextWithParent_shouldCallLoadFixturesOnMainContext()
  {
    $parent = $this->getParentContextMock();
    $mainContext = $parent->getMainContext();
    $mainContext->shouldReceive('loadFixtures')->with(array())->once();
    $this->feature->setParentContext($parent);
    $this->feature->loadFixtures(array());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException RuntimeException
   * @expectedExceptionMessage Sub context has no parent
   */
  public function getReference_contextWithoutParent_shouldThrowException()
  {
    $this->feature->getReference('ref');
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getReference_contextWithParent_shouldCallGetReferenceOnMainContext()
  {
    $parent = $this->getParentContextMock();
    $mainContext = $parent->getMainContext();
    $mainContext->shouldReceive('getReference')->with('ref')->once();
    $this->feature->setParentContext($parent);
    $this->feature->getReference('ref');
  }

  private function getKernelMock()
  {
    $container = m::mock('stdClass');
    $container->shouldReceive('get')->andReturn($this->translator);
    $kernel = m::mock('Symfony\Component\HttpKernel\KernelInterface');
    $kernel->shouldReceive('getContainer')->andReturn($container);

    return $kernel;
  }
}
