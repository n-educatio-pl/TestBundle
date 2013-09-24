<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver
 */
class UniqueDependencyResolverForComponentWithManyChildrenShould extends UniqueDependencyResolverTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItsChildrenAndHimSelfAtTheEnd()
  {
    $expectedComponents = array('J', 'K', 'G');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['G']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItsOffspringRecursivelyAsFirstAndHimSelfAtTheEnd()
  {
    $expectedComponents = array('I', 'H', 'F');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['F']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItsOffspringRecursivelyAsFirstAndHimSelfAtTheEndForComponentWithFourChildren()
  {
    $expectedComponents = array('D', 'I', 'H', 'E', 'B');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['B']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItsOffspringRecursivelyAsFirstAndHimSelfAtTheEndForComponentWithSixChildren()
  {
    $expectedComponents = array('I', 'H', 'F', 'J', 'K', 'G', 'C');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['C']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithoutDuplicatedComponentsForComponentWithAllOffspring()
  {
    $expectedComponents = array('D', 'I', 'H', 'E', 'B', 'F', 'J', 'K', 'G', 'C', 'A');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['A']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithoutDuplicatedComponentsForRootComponentWithAllOffspring()
  {
    $expectedComponents = array('D', 'I', 'H', 'E', 'B', 'F', 'J', 'K', 'G', 'C', 'A', 'L');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['root']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
}