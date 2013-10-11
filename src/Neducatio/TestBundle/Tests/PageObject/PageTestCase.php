<?php
namespace Neducatio\TestBundle\Tests\PageObject;

use \Mockery as m;
use Behat\Mink\Element\TraversableElement;

/**
 * Page test case
 */
abstract class PageTestCase extends \PHPUnit_Framework_TestCase
{
  protected $harvester;
  protected $pageObject;
  protected $page;
  protected $subpage;

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->page = $this->getPage();
    $this->subpage = $this->getSubPage();
    $this->pageObject = $this->getPageObject($this->page);
  }

  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Gets PageObject
   */
  abstract protected function getPageObject();

  /**
   * Do sth.
   * 
   * @param TraversableElement $page Page/subpage to be passed to validator
   *
   * @return PageObjectBuilder
   */
  protected function getBuilder(TraversableElement $page)
  {
    $validator = m::mock('stdClass');
    $validator->shouldReceive('validate')->byDefault();
    $this->harvester = m::mock('Neducatio\TestBundle\Utility\HookHarvester');
    $this->harvester->shouldReceive('registerHooks')->byDefault();
    $awaiter = m::mock("Neducatio\TestBundle\Utility\Awaiter\PageAwaiter");
    $builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $builder->shouldReceive('getValidator')->andReturn($validator)->with($page);
    $builder->shouldReceive('getHarvester')->andReturn($this->harvester);
    $builder->shouldReceive('getAwaiter')->andReturn($awaiter);

    return $builder;
  }

  /**
   * Creates DocumentElement mock
   *
   * @return DocumentElement
   */
  protected function getPage()
  {
    return m::mock('\Behat\Mink\Element\DocumentElement');
  }

  /**
   * Creates DocumentElement mock
   *
   * @return DocumentElement
   */
  protected function getSubPage()
  {
    return m::mock('\Behat\Mink\Element\NodeElement');
  }
}