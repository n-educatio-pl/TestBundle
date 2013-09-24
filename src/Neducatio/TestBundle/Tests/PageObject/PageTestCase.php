<?php
namespace Neducatio\TestBundle\Tests\PageObject;

use \Mockery as m;

/**
 * Page test case
 */
abstract class PageTestCase extends \PHPUnit_Framework_TestCase
{
  protected $harvester;
  protected $pageObject;
  protected $page;

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->page = $this->getPage();
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
   * @return PageObjectBuilder
   */
  protected function getBuilder()
  {
    $validator = m::mock('stdClass');
    $validator->shouldReceive('validate')->byDefault();
    $this->harvester = m::mock('Neducatio\TestBundle\Utility\HookHarvester');
    $this->harvester->shouldReceive('registerHooks')->byDefault();
    $builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $builder->shouldReceive('getValidator')->andReturn($validator);
    $builder->shouldReceive('getHarvester')->andReturn($this->harvester);

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
}