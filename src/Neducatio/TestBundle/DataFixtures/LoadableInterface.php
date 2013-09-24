<?php

namespace Neducatio\TestBundle\DataFixtures;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Loadable interface
 */
interface LoadableInterface extends ContainerAwareInterface
{
  /**
   * Get dependencies
   * 
   * @return array
   */
  public function getDependentClasses();
}
