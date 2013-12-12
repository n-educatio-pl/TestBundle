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
  public function getPageElement_returnPagePassedInConstructor()
  {
    $this->assertSame($this->page, $this->pageObject->getPageElement());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getProofSelector_returnProofSelectorFromPageObject()
  {
    $this->assertSame('selector', $this->pageObject->getProofSelector());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getSubPageObjectsData_returnSubPageObjectsDataFromPageObject()
  {
    $this->assertSame(array('some_selector' => 'someClass'), $this->pageObject->getSubPageObjectsData());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function get_someKeyPassed_shouldReturnHook()
  {
    $this->harvester->shouldReceive('get')->with('someKey', 0)->andReturn('hook')->once();
    $this->assertSame('hook', $this->pageObject->get('someKey'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function getAllByKey_someKeyPassed_shouldReturnHooks()
  {
    $this->harvester->shouldReceive('getAllByKey')->with('someKey')->andReturn(array('hook1','hook2'))->once();
    $this->assertSame(array('hook1','hook2'), $this->pageObject->getAllByKey('someKey'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function has_someKeyPassed_shouldReturnHasFromHook()
  {
    $this->harvester->shouldReceive('has')->with('someKey')->andReturn(true)->once();
    $this->assertSame(true, $this->pageObject->has('someKey'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getAwaiter_shouldReturnAwaiterFromBuilder()
  {
    $node = m::mock('\Behat\Mink\Element\NodeElement');
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\PageAwaiter', $this->pageObject->getAwaiter($node));
    $this->assertSame($this->pageObject->builder->getAwaiter($node), $this->pageObject->getAwaiter($node));
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
    $this->pageObject = new TestableBasePage($this->page, $this->getBuilder($this->page), $this->getHarvester(), $parentPageObject);
    $this->assertSame($parentPageObject, $this->pageObject->getParent());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function buildPageObjectByName_ValidNamePassedAndSessionIsSet_shouldReturnValidNewPageObject()
  {
    $builder = $this->getBuilder($this->page);
    $builder->shouldReceive('build')->with('validName')->andReturn('PageObject')->once();
    $this->pageObject = new TestableBasePage($this->page, $builder, $this->getHarvester());
    $this->assertSame('PageObject', $this->pageObject->buildPageObjectByName('validName'));
  }

  /**
   * Gets PageObject
   *
   * @return PageObject
   */
  protected function getPageObject()
  {
    return new TestableBasePage($this->page, $this->getBuilder($this->page), $this->getHarvester());
  }
  /**
   * Gets PageObject
   *
   * @return PageObject
   */
  protected function getSubPageObject()
  {
    return new TestableBasePage($this->subpage, $this->getBuilder($this->subpage), $this->getHarvester());
  }
}