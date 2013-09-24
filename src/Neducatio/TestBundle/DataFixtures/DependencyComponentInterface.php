<?php

namespace Neducatio\TestBundle\DataFixtures;

/**
 * Dependency Component Interface
 */
interface DependencyComponentInterface
{
  /**
   * Get identifier
   * 
   * @return integer
   */
  public function getId();
  /**
   * Get children
   * 
   * @return array
   */
  public function getChildren();
  /**
   * Adds subcomponent.
   *
   * @param DependencyComponentInterface $child subcomponent
   */
  public function add(DependencyComponentInterface $child);
}