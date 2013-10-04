<?php

namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Tests\Utility\Awaiter\TestablePageAwaiter;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter\PageAwaiter
 */
class PageAwaiterTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Tests constructor
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\PageAwaiter', $this->getAwaiter());
  }

  /**
   * @test
   */
  public function setPage_DocumentElementPassed_shouldSetPage()
  {
    $page = m::mock("\Behat\Mink\Element\DocumentElement");
    $awaiter = $this->getAwaiter();
    $this->assertNull($awaiter->getPage());
    $awaiter->setPage($page);
    $this->assertSame($page, $awaiter->getPage());
  }

  /**
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\DocumentElementNotSetException
   */
  public function waitUntilVisible_pageNotSetted_shouldThrowException()
  {
    $awaiter = $this->getAwaiter();
    $awaiter->waitUntilVisible("selector", "css");
  }

  /**
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException
   */
  public function waitUntilVisible_elementNotPresentInPage_shouldThrowException()
  {
    $selector = "#t_element";
    $type = "css";
    $page = $this->createPageMockWithoutElement($selector, $type);
    $awaiter = $this->getAwaiter($page);
    $awaiter->waitUntilVisible($selector, $type);
  }

  /**
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException
   */
  public function waitUntilVisible_elementPresentButInvisible_shouldThrowException()
  {
    $selector = "#t_element";
    $type = "css";
    $page = $this->createPageMockWithInvisibleElement($selector, $type);
    $awaiter = $this->getAwaiter($page);
    $awaiter->waitUntilVisible($selector, $type);
  }

  /**
   * @test
   */
  public function waitUntilVisible_elementPresentAndVisible_shouldNotThrowException()
  {
    $selector = "#t_element";
    $type = "css";
    $page = $this->createPageMockWithVisibleElement($selector, $type);
    $awaiter = $this->getAwaiter($page);
    $awaiter->waitUntilVisible($selector, $type);
  }

  /**
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\DocumentElementNotSetException
   */
  public function waitUntilDisappear_pageNotSetted_shouldThrowException()
  {
    $awaiter = $this->getAwaiter();
    $awaiter->waitUntilDisappear("selector", "css");
  }

  /**
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException
   */
  public function waitUntilDisappear_elementNotDisappear_shouldThrowException()
  {
    $selector = "#t_element";
    $page = $this->createPageMockContainingElement($selector);
    $awaiter = $this->getAwaiter($page);
    $awaiter->waitUntilDisappear($selector, 'css');
  }

  /**
   * @test
   */
  public function waitUntilDisappear_elementDisappear_shouldNotThrowException()
  {
    $selector = "#t_element";
    $page = $this->createPageMockNotContainingElement($selector);
    $awaiter = $this->getAwaiter($page);
    $awaiter->waitUntilDisappear($selector, 'css');
  }

  private function createPageMockWithConfiguredElement($selector, $type, $hasElement, $isElementVisible)
  {
    $page = m::mock("\Behat\Mink\Element\DocumentElement");
    $element = null;
    if ($hasElement) {
      $element = m::mock("\Behat\Mink\Element\NodeElement");
      $element->shouldReceive("isVisible")->andReturn($isElementVisible)->atLeast()->times(1);
    }
    $page->shouldReceive("find")->with($type, $selector)->andReturn($element)->atLeast()->times(1);

    return $page;
  }

  private function createPageMockWithoutElement($selector, $type)
  {
    return $this->createPageMockWithConfiguredElement($selector, $type, false, false);
  }

  private function createPageMockWithInvisibleElement($selector, $type)
  {
    return $this->createPageMockWithConfiguredElement($selector, $type, true, false);
  }

  private function createPageMockWithVisibleElement($selector, $type)
  {
    return $this->createPageMockWithConfiguredElement($selector, $type, true, true);
  }

  private function createPageMockWithOptionalElement($selector, $hasElement)
  {
    $page = m::mock("\Behat\Mink\Element\DocumentElement");
    $page->shouldReceive("has")->with('css', $selector)->andReturn($hasElement)->atLeast()->times(1);

    return $page;
  }

  private function createPageMockContainingElement($selector)
  {
    return $this->createPageMockWithOptionalElement($selector, true);
  }

  private function createPageMockNotContainingElement($selector)
  {
    return $this->createPageMockWithOptionalElement($selector, false);
  }

  /**
   * Create and return new Awaiter object
   *
   * @param DocumentElement $page $page
   * 
   * @return PageAwaiter
   */
  private function getAwaiter($page = null)
  {
    $awaiter = new TestablePageAwaiter();;
    if ($page !== null) {
      $awaiter->setPage($page);
    }

    return $awaiter;
  }
}