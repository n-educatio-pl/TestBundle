<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\HookHarvester;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\HookHarvester
 */
class HookHarvesterTest extends \PHPUnit_Framework_TestCase
{
  private $builder;
  private $harvester;
  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->builder = m::mock('Neducatio\TestBundle\PageObject\PageObjectBuilder');
    $this->harvester = new HookHarvester($this->builder);
  }

  /**
   * Do sth.
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
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\HookHarvester', $this->harvester);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getRegister_validHarvestWithoutHooks_shouldReturnEmptyRegister()
  {
    $this->assertCount(0, $this->harvester->getRegister());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Proof selector not found.
   */
  public function registerHooks_pageWithoutGivenProofSelector_shouldThrowException()
  {
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult(), '.t_someSelector'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooks_validHarvestWithTwoHooksInDifferentNodes_shouldReturnTwoHooksInArray()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1', 'hook2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooks_validHarvestWithTwoHooksWithSomeUpperCaseLettersInDifferentNodes_shouldReturnTwoHooksInArray()
  {
    $hook1 = $this->getHook('t_hOOk1');
    $hook2 = $this->getHook('t_HooK2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hOOk1', 'HooK2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooks_validHarvestWithTwoHooksInDifferentNodesWithSomeGarbageClasses_shouldReturnTwoHooksInArray()
  {
    $hook1 = $this->getHook('klasa klasa_klas t_hook1 klasa_klas');
    $hook2 = $this->getHook('klasa_ _klasa-klas t_hook2 klasa');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1', 'hook2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooks_validHarvestWithTwoHooksInSameNode_shouldReturnTwoHooksInArray()
  {
    $hook1 = $this->getHook('t_hook1 t_hook2');
    $harvest = $this->getNodeElement(array($hook1));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1', 'hook2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooks_validHarvestWithTwoHooksInSameNodeWithSomeGarbageClasses_shouldReturnTwoHooksInArray()
  {
    $hook1 = $this->getHook('klasa-klas t_hook1 moja_klasa t_hook2 klasa');
    $harvest = $this->getNodeElement(array($hook1));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1', 'hook2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   * @group aaab
   */
  public function registerHooks_validHarvestWithTwoHooksInDifferentNodes_subPageDataPassedAndClassFound_shouldReturnTwoHooksInArrayOneAsSubPage()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $mainPageObject = $this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector', array('hook2' => 'someClass'));
    $this->builder->shouldReceive('build')->with('someClass', $hook2, $mainPageObject)->andReturn('someSubPage');
    $this->harvester->registerHooks($mainPageObject);
    $this->assertSame(array('hook1' => array($hook1), 'hook2' => array('someSubPage')), $this->harvester->getRegister());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Proof selector not found.
   */
  public function registerHooksFromPrompt_pageWithoutPrompt_shouldThrowException()
  {
    $page = m::mock('\Behat\Mink\Element\DocumentElement');
    $page->shouldReceive('find')->with('css', '.t_someSelector')->andReturn(null);
    $page->shouldReceive('find')->with('css', '.ui-dialog-content')->andReturn(null);
    $this->harvester->registerHooksFromPrompt($this->getPageObject($page, '.t_someSelector'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function registerHooksFromPrompt_validHarvestWithOneHook_shouldAddOneHookToArray()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $page = m::mock('\Behat\Mink\Element\DocumentElement');
    $page->shouldReceive('find')->with('css', '.t_someSelector')->andReturn(null);
    $page->shouldReceive('find')->with('css', '.ui-dialog-content')->andReturn($harvest);
    $this->harvester->registerHooksFromPrompt($this->getPageObject($page, '.t_someSelector'));
    $this->assertSame(array('hook1', 'hook2'), array_keys($this->harvester->getRegister()));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function count_nonExistsingKey_shouldReturnZero()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(0, $this->harvester->count('t_nonhook'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function count_existsingKey_shouldReturnCount()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(1, $this->harvester->count('hook1'));
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Hook not_existing_key not found.
   */
  public function get_notExistingKeyIsPassed_shouldThrowAnException()
  {
    $this->harvester->get('not_existing_key');
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function get_existingKeyIsPassed_shouldReturnHook()
  {
    $hook = $this->getHook('t_existing_key');
    $harvest = $this->getNodeElement(array($hook));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(get_class($hook), get_class($this->harvester->get('existing_key')));
  }

  /**
   * Do sth.
   *
   * @test
   * @group aaab
   */
  public function get_existingKeyWithSubPagePassed_shouldReturnSubpage()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook2');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $mainPageObject = $this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector', array('hook2' => 'someClass'));
    $this->builder->shouldReceive('build')->with('someClass', $hook2, $mainPageObject)->andReturn('someSubPage');
    $this->harvester->registerHooks($mainPageObject);
    $this->assertSame('someSubPage', $this->harvester->get('hook2'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function get_keyWhereAreTwoNodesIsPassed_shouldReturnFirstHook()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook1');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1'), array_keys($this->harvester->getRegister()));
    $this->assertInstanceOf(get_class($hook1), $this->harvester->get('hook1'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function get_keyWhereAreTwoNodesAndSecondPlaceIsPassed_shouldReturnSecondHook()
  {
    $hook1 = $this->getHook('t_hook1');
    $hook2 = $this->getHook('t_hook1');
    $harvest = $this->getNodeElement(array($hook1, $hook2));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array('hook1'), array_keys($this->harvester->getRegister()));
    $this->assertInstanceOf(get_class($hook2), $this->harvester->get('hook1', 1));
  }

  /**
   * Do sth.
   *
   * @test
   *
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Hook hook1 not found.
   */
  public function getAllByKey_keyWhereIsNoNodes_shouldThrowsInvalidArgumentException()
  {
      $this->harvester->getAllByKey('hook1');
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getAllByKey_keyWhereIsOneNode_shouldReturnArrayWithNode()
  {
    $hook = $this->getHook('t_hook1');
    $harvest = $this->getNodeElement(array($hook));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertSame(array($hook), $this->harvester->getAllByKey('hook1'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getAllByKey_keyWhereAreTwoNodes_shouldReturnArrayWithNodes()
  {
      $hook1 = $this->getHook('t_hook1');
      $hook2 = $this->getHook('t_hook1');
      $harvest = $this->getNodeElement(array($hook1, $hook2));
      $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
      $this->assertSame(array($hook1, $hook2), $this->harvester->getAllByKey('hook1'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function has_notExistingKeyIsPassed_shouldReturnFalse()
  {
    $this->assertFalse($this->harvester->has('not_existing_key'));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function has_existingKeyIsPassed_shouldReturnTrue()
  {
    $hook = $this->getHook('t_existing_key');
    $harvest = $this->getNodeElement(array($hook));
    $this->harvester->registerHooks($this->getPageObject($this->getPageWithResult($harvest), '.t_someSelector'));
    $this->assertTrue($this->harvester->has('existing_key'));
  }

  private function getPageObject(\Behat\Mink\Element\TraversableElement $element, $selector, $subPageObjectsData = array())
  {
      $pageObject = m::mock('\Neducatio\TestBundle\PageObject\BasePageObject');
      $pageObject->shouldReceive('getPageElement')->andReturn($element);
      $pageObject->shouldReceive('getProofSelector')->andReturn($selector);
      $pageObject->shouldReceive('getSubPageObjectsData')->andReturn($subPageObjectsData);

      return $pageObject;
  }

  /**
   * Do sth
   *
   * @param NodeElement $harvest Harvest of given page
   *
   * @return DocumentElement mock
   */
  private function getPageWithResult($harvest = null)
  {
    $page = m::mock('\Behat\Mink\Element\DocumentElement');
    $page->shouldReceive('find')->with('css', '.t_someSelector')->andReturn($harvest);

    return $page;
  }

  /**
   * Gets Hook
   *
   * @param string $classes Complex string of classes
   *
   * @return NodeElement
   */
  private function getHook($classes)
  {
    $hook = m::mock('Behat\Mink\Element\NodeElement');
    $hook->shouldReceive('getAttribute')->with('class')->andReturn($classes);

    return $hook;
  }

  /**
   * Do sth.
   *
   * @param array $hooks Hooks
   *
   * @return NodeElement mock
   */
  private function getNodeElement($hooks = array())
  {
    $node = m::mock('Behat\Mink\Element\NodeElement');
    $node->shouldReceive('findAll')->with('xpath', "//*[contains(@class, 't_')]")->andReturn($hooks);

    return $node;
  }
}