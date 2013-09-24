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
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\HookHarvester', $this->getHarvester());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function getRegister_validHarvestWithoutHooks_shouldReturnEmptyRegister()
  {
    $harvester = $this->getHarvester();
    $this->assertCount(0, $harvester->getRegister());
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
    $this->getHarvester()->registerHooks($this->getPageWithResult(), '.t_someSelector');
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
    $harvester = $this->getHarvester();
    $harvester->registerHooks($this->getPageWithResult($harvest), '.t_someSelector');
    $this->assertSame(array('hook1', 'hook2'), array_keys($harvester->getRegister()));
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
    $harvester = $this->getHarvester();
    $harvester->registerHooks($this->getPageWithResult($harvest), '.t_someSelector');
    $this->assertSame(array('hook1', 'hook2'), array_keys($harvester->getRegister()));
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
    $harvester = $this->getHarvester();
    $harvester->registerHooks($this->getPageWithResult($harvest), '.t_someSelector');
    $this->assertSame(array('hook1', 'hook2'), array_keys($harvester->getRegister()));
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
    $harvester = $this->getHarvester();
    $harvester->registerHooks($this->getPageWithResult($harvest), '.t_someSelector');
    $this->assertSame(array('hook1', 'hook2'), array_keys($harvester->getRegister()));
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
    $this->getHarvester()->get('not_existing_key');
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
    $harvester = $this->getHarvester();
    $harvester->registerHooks($this->getPageWithResult($harvest), '.t_someSelector');
    $this->assertSame(get_class($hook), get_class($harvester->get('existing_key')));
  }

  /**
   * Do sth.
   *
   * @return HookHaverster
   */
  private function getHarvester()
  {
    return new HookHarvester();
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