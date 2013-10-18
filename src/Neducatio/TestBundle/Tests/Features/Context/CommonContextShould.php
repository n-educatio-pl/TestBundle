<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use Neducatio\TestBundle\Features\Context\CommonContext;
use Neducatio\TestBundle\Features\Context\BaseSubContext;

use Mockery as m;
/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Features\Context\CommonContext
 */
class CommonContextShould extends SubContextTestCase
{
    private $context;
    /**
     * Instantiate class under test.
     *
     */
    public function setUp()
    {
      $this->context = new CommonContext($this->getKernelMock());
      $this->context->setBuilder($this->getPageObjectBuilderMock());
      $this->context->setParentContext($this->getParentContextMock());
    }
    /**
     * Do sth.
     *
     * @test
     */
    public function beAbleToLoadFixturesWhenPreparingSystem()
    {
        $expectedFixtures = array('foo');
        $this->context->getMainContext()->getRegistry()
                ->shouldReceive('get')
                ->with(BaseSubContext::FIXTURES_KEY)
                ->andReturn($expectedFixtures);
        $this->context->getMainContext()
                ->shouldReceive('loadFixtures')
                ->once()
                ->with($expectedFixtures);

        $this->context->systemReadyToBeTested();
    }

    private function getKernelMock()
    {
      $container = m::mock('stdClass');
      $kernel = m::mock('Symfony\Component\HttpKernel\KernelInterface');
      $kernel->shouldReceive('getContainer')->andReturn($container);

      return $kernel;
    }
}