<?php

namespace Neducatio\TestBundle\Tests\PageObject;

use Neducatio\TestBundle\PageObject\PageObjectBuilder;
use Mockery as m;

/**
 * Page object builder
 *
 * @covers Neducatio\TestBundle\PageObject\PageObjectBuilder
 */
class PageObjectBuilderTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Tears down
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
  public function __construct_shouldCreateInstance()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\PageObject\PageObjectBuilder', $this->getBuilder());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function build_validPageNameAndDocumentElementArePassed_shouldReturnInstanceOfGivenPageAndSetDocumentElementInAwaiter()
  {
    $builder = $this->getBuilder();
    $documentElement = $this->getPage();
    $basePage = $builder->build(TestableBasePage::NAME, $documentElement);
    $this->assertInstanceOf('Neducatio\TestBundle\Tests\PageObject\TestableBasePage', $basePage);
    $this->assertSame($documentElement, $builder->getAwaiter()->getPage());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getValidator_shouldReturnInstanceOfValidator()
  {
    $builder = $this->getBuilder();
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\DocumentElementValidator', $builder->getValidator());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getHarvester_shouldReturnInstanceOfValidator()
  {
    $builder = $this->getBuilder();
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\HookHarvester', $builder->getHarvester());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getAwaiter_shouldReturnInstanceOfPageAvaiter()
  {
    $builder = $this->getBuilder();
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\PageAwaiter', $builder->getAwaiter());
  }

  /**
   * Gets Builder
   *
   * @return PageObjectBuilder
   */
  private function getBuilder()
  {
    return new PageObjectBuilder();
  }

  /**
   * Gets node element
   *
   * @param bool $visiblity Vsibility of the node element
   *
   * @return NodeElement
   */
  protected function getNodeElement($visiblity = true)
  {
    $node = m::mock('\Behat\Mink\Element\NodeElement');
    $node->shouldReceive('isVisible')->andReturn($visiblity)->byDefault();

    return $node;
  }

  /**
   * Creates DocumentElement mock
   *
   * @return DocumentElement
   */
  protected function getPage()
  {
    $session = m::mock('\stdClass');
    $session->shouldReceive('wait')->byDefault();

    $harvest = m::mock('\stdClass');
    $harvest->shouldReceive('findAll')->andReturn(array())->byDefault();

    $selectors = array($this->getNodeElement());

    $page = m::mock('\Behat\Mink\Element\DocumentElement');
    $page->shouldReceive('find')->andReturn($harvest)->byDefault();
    $page->shouldReceive('findAll')->andReturn($selectors)->byDefault();
    $page->shouldReceive('getContent')->andReturn('</html>')->byDefault();
    $page->shouldReceive('getSession')->andReturn($session)->byDefault();

    return $page;
  }
}
