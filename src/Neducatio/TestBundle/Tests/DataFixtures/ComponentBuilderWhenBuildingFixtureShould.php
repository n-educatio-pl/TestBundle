<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;


/**
 * Do sth.
 *
 * @group integration
 *
 * @covers Neducatio\TestBundle\DataFixtures\ComponentBuilder
 */
class ComponentBuilderWhenBuildingFixtureShould extends ComponentBuilderTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function returnInstanceOfComponent()
  {
    $component = $this->builder->build($this->loadableClasses['Z']);
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\DependencyComponentInterface', $component);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function instantiateAndInjectFixtureToComponent()
  {
    $component = $this->builder->build($this->loadableClasses['Z']);
    $this->assertInstanceOf($this->loadableClasses['Z'], $component->getFixture());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function injectContainerToFixture()
  {
    $component = $this->builder->build($this->loadableClasses['Z']);
    $this->assertSame($this->container, $component->getFixture()->getContainer());
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function setComponentIdAsFixtureClass()
  {
    $component = $this->builder->build($this->loadableClasses['Z']);
    $this->assertSame($this->loadableClasses['Z'], $component->getId());
  }
}
