<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;


/**
 * Do sth.
 *
 * @group integration
 *
 * @covers Neducatio\TestBundle\DataFixtures\ComponentBuilder
 */
class ComponentBuilderWhenBuildingFixtureWithDependencyShould extends ComponentBuilderTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function createComponentWithSubcomponent()
  {
    $component = $this->builder->build($this->loadableClasses['Y']);
    $children = $component->getChildren();
    $this->assertCount(1, $children);
    $subcomponent = array_pop($children);
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface', $subcomponent);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function createComponentWithThisDependencyAsChild()
  {
    $component = $this->builder->build($this->loadableClasses['Y']);
    $children = $component->getChildren();
    $this->assertCount(1, $children);
    $subcomponent = array_pop($children);
    $this->assertInstanceOf($this->loadableClasses['Z'], $subcomponent->getFixture());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function fixtureInDependencyShareTheSameContainer()
  {
    $component = $this->builder->build($this->loadableClasses['Y']);
    $children = $component->getChildren();
    $subcomponent = array_pop($children);
    $this->assertSame($this->container, $subcomponent->getFixture()->getContainer());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function dependencyHaveConfiguredFixture()
  {
    $component = $this->builder->build($this->loadableClasses['Y']);
    $children = $component->getChildren();
    $subcomponent = array_pop($children);
    $this->assertSame($this->loadableClasses['Z'], $subcomponent->getId());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function createRecursively()
  {
    $component = $this->builder->build($this->loadableClasses['P']);
    $subcomponents = $component->getChildren();
    $this->assertInstanceOf($this->loadableClasses['X'], $subcomponents[0]->getFixture());
    $this->assertInstanceOf($this->loadableClasses['Y'], $subcomponents[1]->getFixture());
    $subsubcomponents = $subcomponents[1]->getChildren();
    $this->assertInstanceOf($this->loadableClasses['Z'], $subsubcomponents[0]->getFixture());
  }
}
