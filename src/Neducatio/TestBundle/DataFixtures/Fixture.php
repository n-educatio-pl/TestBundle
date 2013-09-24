<?php

namespace Neducatio\TestBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Neducatio\TestBundle\DataFixtures\LoadableInterface;

/**
 * Fixture base
 */
abstract class Fixture extends AbstractFixture implements LoadableInterface
{
  const NAME = __CLASS__;
  protected $container;
  protected $dependentClasses = array();

  /**
   * Set container
   *
   * @param ContainerInterface $container Container
   */
  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }
  /**
   * Do sth.
   *
   * @return ContainerInterface Container
   */
  public function getContainer()
  {
    return $this->container;
  }
  /**
   * Get dependencies
   *
   * @return array
   */
  public function getDependentClasses()
  {
    return $this->dependentClasses;
  }
}
