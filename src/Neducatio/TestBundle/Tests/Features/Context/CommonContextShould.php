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
      $parameters = array(
        'builder' => $this->getPageObjectBuilderMock()
      );
      $this->context = new CommonContext($parameters);
      $this->context->setParentContext($this->getParentContextMock());
    }
    /**
     * Do sth.
     *
     * @test
     */
    public function beAbleToLoadFixturesWhenPreparingSystem()
    {
        $fixtures = array('foo');
        $this->prepareFixturesToBeLoaded($fixtures);
        $this->assertFixturesLoaded($fixtures);

        $this->context->systemReadyToBeTested();
    }


    private function prepareFixturesToBeLoaded($fixtures)
    {
        $this->context->getMainContext()->getRegistry()
            ->shouldReceive('get')
            ->with(BaseSubContext::FIXTURES_KEY)
            ->andReturn($fixtures);
    }

    private function assertFixturesLoaded($expectedFixtures)
    {
        $this->context->getMainContext()
            ->shouldReceive('loadFixtures')
            ->once()
            ->with($expectedFixtures);
    }


}