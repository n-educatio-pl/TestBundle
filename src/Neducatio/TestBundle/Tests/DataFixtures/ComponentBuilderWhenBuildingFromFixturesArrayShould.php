<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;


/**
 * Do sth.
 *
 * @group integration
 *
 * @covers Neducatio\TestBundle\DataFixtures\ComponentBuilder
 */
class ComponentBuilderWhenBuildingFromFixturesArrayShould extends ComponentBuilderTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function returnBondingComponentWithoutChildrenWhenEmptyArrayPassed()
  {
    $component = $this->builder->buildFromArray(array());
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\BondingComponent', $component);
    $this->assertSame(array(), $component->getChildren());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function shouldReturnBondingComponentWithTwoChildrenWhenArrayWithTwoChildrenPassed()
  {
    $children = array($this->loadableClasses['P'], $this->loadableClasses['X']);
    $component = $this->builder->buildFromArray($children);
    $resultChildren = $component->getChildren();

    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\FixtureComponentInterface', $resultChildren[0]);
    $this->assertInstanceOf($this->loadableClasses['P'], $resultChildren[0]->getFixture());
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\FixtureComponentInterface', $resultChildren[1]);
    $this->assertInstanceOf($this->loadableClasses['X'], $resultChildren[1]->getFixture());
  }
}