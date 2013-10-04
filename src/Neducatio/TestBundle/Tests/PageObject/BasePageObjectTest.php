<?php

namespace Neducatio\TestBundle\Tests\PageObject;

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
   * Gets PageObject
   *
   * @return PageObject
   */
  protected function getPageObject()
  {
    return new TestableBasePage($this->page, $this->getBuilder());
  }
}