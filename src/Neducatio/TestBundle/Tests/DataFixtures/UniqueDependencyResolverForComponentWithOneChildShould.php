<?php
namespace Neducatio\TestBundle\Tests\DataFixtures;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver
 */
class UniqueDependencyResolverForComponentWithOneChildShould extends UniqueDependencyResolverTestCase
{
  /**
   * Do sth.
   *
   * @test
   */
  public function returnArrayWithItsChildAndHimSelfAtTheEnd()
  {
    $expectedComponents = array('I', 'H');
    $resolvedComponents = $this->uniqueDependencyResolver->resolve($this->dependentComponentsTree['H']);
    $this->assertSameDependentComponentsIds($expectedComponents, $resolvedComponents);
  }
}