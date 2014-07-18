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
  protected $session;
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
    $awaiter = m::mock("Neducatio\TestBundle\Utility\Awaiter\PageAwaiter");
    $builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $builder->shouldReceive('getValidator')->andReturn($validator)->with($page);
    $builder->shouldReceive('getAwaiter')->andReturn($awaiter);
    $createdPageObject = m::mock('Neducatio\TestBundle\PageObject\BasePageObject');
    $builder->shouldReceive('build')->andReturn($createdPageObject)->byDefault();

    return $builder;
  }

  protected function getHarvester()
  {
    $this->harvester = m::mock('Neducatio\TestBundle\Utility\HookHarvester');
    $this->harvester->shouldReceive('registerHooks')->byDefault();

    return $this->harvester;
  }

  protected function getSession()
  {
    $this->session = m::mock('\Behat\Mink\Session');

    return $this->session;
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