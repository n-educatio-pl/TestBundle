<?php

namespace Neducatio\TestBundle\DataFixtures;

/**
 * Fixture Component Interface
 */
interface FixtureComponentInterface extends DependencyComponentInterface
{
  /**
   * Get fixture
   * 
   * @return Fixture
   */
  public function getFixture();
}