<?php
namespace Neducatio\TestBundle\DataFixtures;

use \Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * FixtureLoader
 */
class FixtureLoader
{
  protected $invoker;
  protected $fixtures;

  /**
   * Constructor
   * 
   * @param FixtureDependencyInvoker $invoker        Fixture Dependency Invoker
   * @param array                    $fixtureClasses Array with fixtures classes names
   */
  public function __construct(FixtureDependencyInvoker $invoker, array $fixtureClasses)
  {
     $this->invoker  = $invoker;
     $this->fixtures = $this->createFixtures($fixtureClasses);
  }

  /**
   * Load fixtures
   */
  public function load()
  {
    $this->cleanReferenceRepository();
    $this->invoker->getFixtureExecutor()->execute($this->fixtures);
  }

  /**
   * Helper function that provides object referenced by name (as in fixture loading).
   *
   * @param string $refName Reference name (eg. 'published-10')
   *
   * @return mixed referenced object or null if no fixtures.
   */
  public function getReference($refName)
  {
    return $this->invoker->getExecutor()->getReferenceRepository()->getReference($refName);
  }

  /**
   * Clean reference repository
   */
  private function cleanReferenceRepository()
  {
    $refRepository = new ReferenceRepository($this->invoker->getEntityManager());
    $this->invoker->getExecutor()->setReferenceRepository($refRepository);
  }

  /**
   * Create fixtures from given fixture class
   * 
   * @param array $fixtureClasses Array with fixtures classes names
   *
   * @return array
   */
  private function createFixtures(array $fixtureClasses)
  {
    $component = $this->invoker->getComponentBuilder()->buildFromArray($fixtureClasses);

    return $this->invoker->getUniqueDependencyResolver()->resolve($component);
  }
}

