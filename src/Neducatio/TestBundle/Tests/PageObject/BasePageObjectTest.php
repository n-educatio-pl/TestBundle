<?php

namespace Neducatio\TestBundle\Tests\PageObject;

use \Mockery as m;

/**
 * Abstract BasePageObject tests
 *
 * @covers Neducatio\TestBundle\PageObject\BasePageObject
 */
class BasePageObjectTest extends PageTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function __construct_validPage_shouldCreateInstance()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\PageObject\BasePageObject', $this->pageObject);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function __construct_validSubPage_shouldCreateInstance()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\PageObject\BasePageObject', $this->getSubPageObject());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function get_someKeyPassed_shouldReturnHook()
  {
    $this->harvester->shouldReceive('get')->with('someKey', 0)->andReturn('hook');
    $this->assertSame('hook', $this->pageObject->get('someKey'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getAwaiter_shouldReturnAwaiterFromBuilder()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\PageAwaiter', $this->pageObject->getAwaiter());
    $this->assertSame($this->pageObject->builder->getAwaiter(), $this->pageObject->getAwaiter());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getParent_PageObjectHasNoParentPassed_shouldReturnNull()
  {
    $this->assertNull($this->pageObject->getParent());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getParent_PageObjectHasParentPassed_shouldReturnParentPassedInConstructor()
  {
    $parentPageObject =  m::mock('Neducatio\TestBundle\PageObject\BasePageObject');
    $this->pageObject = new TestableBasePage($this->page, $this->getBuilder($this->page), $parentPageObject);
    $this->assertSame($parentPageObject, $this->pageObject->getParent());
  }

  /**
   * Gets PageObject
   *
   * @return PageObject
   */
  protected function getPageObject()
  {
    return new TestableBasePage($this->page, $this->getBuilder($this->page));
  }
  /**
   * Gets PageObject
   *
   * @return PageObject
   */
  protected function getSubPageObject()
  {
    return new TestableBasePage($this->subpage, $this->getBuilder($this->subpage));
  }
}