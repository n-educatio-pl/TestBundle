<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use Mockery as m;

require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * SubContextTestCase
 */
abstract class SubContextTestCase extends \PHPUnit_Framework_TestCase
{
  protected $pageObject;
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  protected function getPageObjectBuilderMock()
  {
    $builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $builder->shouldReceive('build')->andReturn($this->pageObject);

    return $builder;
  }

  protected function getParentContextMock($documentPage = 'document')
  {
    $session = m::mock('stdClass');
    $session->shouldReceive('getPage')->andReturn($documentPage);
    $mainContext = m::mock('Behat\Behat\Context\ExtendedContextInterface');
    $mainContext->shouldReceive('getSession')->andReturn($session);
    $mainContext->shouldReceive('loadFixtures')->byDefault();
    $mainContext->shouldReceive('visit');
    $context = m::mock('Behat\Behat\Context\ExtendedContextInterface');
    $context->shouldReceive('getMainContext')->andReturn($mainContext);

    return $context;
  }
}
