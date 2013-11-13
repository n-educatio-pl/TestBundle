<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use \Neducatio\TestBundle\Features\Context\BaseSubContext;
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
    $builder->shouldReceive('build')->andReturn($this->pageObject)->byDefault();

    return $builder;
  }

  protected function getParentContextMock($documentPage = null)
  {
    if ($documentPage === null) {
      $documentPage = m::mock('Behat\Mink\Element\DocumentElement');
    }
    $session = m::mock('stdClass');
    $session->shouldReceive('getPage')->andReturn($documentPage)->byDefault();
    $registry = m::mock('stdClass');
    $registry->shouldReceive('get')->andReturn($this->pageObject)->byDefault();
    $registry->shouldReceive('access')->with(BaseSubContext::PAGE_KEY)->andReturn($this->pageObject)->byDefault();
    $registry->shouldReceive('set')->byDefault();
    $mainContext = m::mock('Behat\Behat\Context\ExtendedContextInterface');
    $mainContext->shouldReceive('getSession')->andReturn($session)->byDefault();
    $mainContext->shouldReceive('loadFixtures')->byDefault();
    $mainContext->shouldReceive('visit')->byDefault();
    $mainContext->shouldReceive('getRegistry')->andReturn($registry)->byDefault();
    $context = m::mock('Behat\Behat\Context\ExtendedContextInterface');
    $context->shouldReceive('getMainContext')->andReturn($mainContext);

    return $context;
  }
}
