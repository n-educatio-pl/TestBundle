<?php

namespace Neducatio\TestBundle\DataFixtures;

use \Symfony\Component\DependencyInjection\ContainerInterface;
use \Neducatio\TestBundle\DataFixtures\BondingComponent;

/**
 * Fixture base
 */
class ComponentBuilder
{
  private $container;
  /**
   * Set container
   *
   * @param ContainerInterface $container Container
   */
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }
  /**
   * Do sth.
   *
   * @param string $loadableFixtureClass Class that is used to instantiate loadable object
   *
   * @return DependencyComponentInterface Created component with dependencies
   */
  public function build($loadableFixtureClass)
  {
    $component = $this->prepareComponentFromFixtureClass($loadableFixtureClass);
    foreach ($component->getFixture()->getDependentClasses() as $dependentLoadableFixtureClass) {
      $component->add($this->build($dependentLoadableFixtureClass));
    }

    return $component;
  }

  /**
   * Do sth.
   *
   * @param array $loadableFixtureClasses Array with classes that are used to instantiate loadable objects
   *
   * @return BondingComponent Created bonding component with dependencies
   */
  public function buildFromArray(array $loadableFixtureClasses)
  {
    $bondingComponent = new BondingComponent();
    foreach ($loadableFixtureClasses as $class) {
      $bondingComponent->add($this->build($class));
    }

    return $bondingComponent;
  }

  /**
   * Do sth.
   *
   * @param string $loadableFixtureClass Class that is used to instantiate loadable object
   *
   * @return FixtureComponent Created component without subcomponents
   */
  private function prepareComponentFromFixtureClass($loadableFixtureClass)
  {
    $fixture = new $loadableFixtureClass();
    $fixture->setContainer($this->container);
    $component = new FixtureComponent($fixture);
    $component->setId($loadableFixtureClass);

    return $component;
  }
}
