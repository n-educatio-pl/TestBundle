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
    $this->feature->setParentContext($this->getParentContextMock());
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
    $this->feature->setPage('page');
    $this->assertSame('page', $this->feature->getPage());
  }

  /**
   * Do sth.
   *
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
   * @group integration
   * @test
   */
  public function loadFixtures_someFixturesPassed_shouldThrowException()
  {
    $fixtures = array(
      \Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\TestableFixture::NAME,
    );
    $this->feature->loadFixtures($fixtures);
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
