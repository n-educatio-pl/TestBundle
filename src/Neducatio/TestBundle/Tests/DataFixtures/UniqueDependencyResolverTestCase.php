<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver;
use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver
 */
abstract class UniqueDependencyResolverTestCase extends \PHPUnit_Framework_TestCase
{
  protected $uniqueDependencyResolver;
  protected $dependentComponentsTree;

  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->uniqueDependencyResolver = $this->getUniqueDependencyResolver();
    $this->dependentComponentsTree = $this->createDependentComponentsTree();
  }

  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }
  /**
   * Assert Components
   *
   * @param array $expectedComponentsName Expected components
   * @param array $resolvedComponents     Resolved components
   */
  protected function assertSameDependentComponentsIds(array $expectedComponentsName, array $resolvedComponents)
  {
    $expectedComponents = array();
    foreach ($expectedComponentsName as $name) {
      $expectedComponents[] = $this->dependentComponentsTree[$name]->getId();
    }
    $this->assertSame($expectedComponents, array_keys($resolvedComponents));
  }

  /**
   * Create dependent components tree
   *
   *                root
   *              /      \
   *             /        \
   *            /          \
   *           /            \
   *          A              L
   *        /   \             \
   *       B     C             G
   *      / \   / \           / \
   *     D  E   F  G         J   K
   *         \ /  / \
   *          H  J   K
   *         /
   *        I
   *
   * @return array
   */
  private function createDependentComponentsTree()
  {
    $componentsTree = array();
    $componentsTree['D'] = $this->getFixtureComponentInterface();
    $componentsTree['I'] = $this->getFixtureComponentInterface();
    $componentsTree['H'] = $this->getFixtureComponentInterface(array($componentsTree['I']));
    $componentsTree['E'] = $this->getFixtureComponentInterface(array($componentsTree['H']));
    $componentsTree['B'] = $this->getFixtureComponentInterface(array($componentsTree['D'], $componentsTree['E']));
    $componentsTree['F'] = $this->getFixtureComponentInterface(array($componentsTree['H']));
    $componentsTree['J'] = $this->getFixtureComponentInterface();
    $componentsTree['K'] = $this->getFixtureComponentInterface();
    $componentsTree['G'] = $this->getFixtureComponentInterface(array($componentsTree['J'], $componentsTree['K']));
    $componentsTree['C'] = $this->getFixtureComponentInterface(array($componentsTree['F'], $componentsTree['G']));
    $componentsTree['A'] = $this->getFixtureComponentInterface(array($componentsTree['B'], $componentsTree['C']));
    $componentsTree['L'] = $this->getFixtureComponentInterface(array($componentsTree['G']));
    $componentsTree['root'] = $this->getDependencyComponentInterface(array($componentsTree['A'], $componentsTree['L']));

    return $componentsTree;
  }

  /**
   * Get dependency retriever
   *
   * @return UniqueDependencyResolver
   */
  private function getUniqueDependencyResolver()
  {
    return new UniqueDependencyResolver();
  }

  /**
   * Get DependencyComponentInterface mock
   *
   * @param array $children Children
   *
   * @return DependencyComponentInterface mock
   */
  private function getFixtureComponentInterface($children = array())
  {
    $component =  m::mock('\Neducatio\TestBundle\DataFixtures\FixtureComponentInterface');
    $component->shouldReceive('getChildren')->andReturn($children);
    $component->shouldReceive('getId')->andReturn(spl_object_hash($component));

    return $component;
  }

  /**
   * Get DependencyComponentInterface mock
   *
   * @param array $children Children
   *
   * @return DependencyComponentInterface mock
   */
  private function getDependencyComponentInterface($children = array())
  {
    $component =  m::mock('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface');
    $component->shouldReceive('getChildren')->andReturn($children);

    return $component;
  }
}