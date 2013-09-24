<?php

namespace Neducatio\TestBundle\DataFixtures;

use \Neducatio\TestBundle\DataFixtures\DependencyComponentInterface;
use \Neducatio\TestBundle\DataFixtures\FixtureComponentInterface;

/**
 * Unique dependency retriever
 */
class UniqueDependencyResolver
{
  /**
   * Get recursive sorted unique components
   *
   * @param DependencyComponentInterface $component Component
   *
   * @return array
   */
  public function resolve(DependencyComponentInterface $component)
  {
    $dependentComponents = array();
    foreach ($component->getChildren() as $child) {
      $dependentComponents = array_merge($dependentComponents, $this->resolve($child));
    }
    if ($component instanceof FixtureComponentInterface) {
      $dependentComponents[$component->getId()] = $component;
    }

    return $dependentComponents;
  }
}
