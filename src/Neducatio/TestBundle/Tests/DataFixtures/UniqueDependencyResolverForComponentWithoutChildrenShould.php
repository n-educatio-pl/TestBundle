<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver
 */
class UniqueDependencyResolverWithoutChildrenShould extends UniqueDependencyResolverTestCase
{
 /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItself()
  {
    $expectedComponents = array('I');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['I']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItself2()
  {
    $expectedComponents = array('D');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['D']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
}