<?php

namespace Neducatio\TestBundle\DataFixtures;

/**
 * Do sth.
 */
class BondingComponent implements DependencyComponentInterface
{
  private $children = array();

  /**
   * Do sth.
   *
   * @param DependencyComponentInterface $subcomponent Child component
   */
  public function add(DependencyComponentInterface $subcomponent)
  {
    $this->children[] = $subcomponent;
  }
  /**
   * Do sth.
   *
   * @return null
   */
  public function getId()
  {
    return null;
  }
  /**
   * Do sth.
   *
   * @return array Children
   */
  public function getChildren()
  {
    return $this->children;
  }
}
