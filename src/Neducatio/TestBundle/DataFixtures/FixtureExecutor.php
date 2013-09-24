<?php

namespace Neducatio\TestBundle\DataFixtures;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;

/**
 * Fixture executor
 */
class FixtureExecutor
{
  private $executor;

  /**
   * Constructor
   *
   * @param AbstractExecutor $executor Abstract Executor
   */
  public function __construct(AbstractExecutor $executor)
  {
    $this->executor = $executor;
  }

  /**
   * Execute fixtures
   *
   * @param array $fixtureComponents Fixture Components Array
   *
   * @throws \InvalidArgumentException
   */
  public function execute(array $fixtureComponents)
  {
    if (count($fixtureComponents) === 0) {
      throw new \InvalidArgumentException('There is no fixtures components to execute');
    }
    $fixtures = $this->getFixtures($fixtureComponents);
    $this->executor->execute($fixtures);
  }

  /**
   * Gets fixtures
   *
   * @param array $fixtureComponents Fixture Components Array
   *
   * @return array
   *
   * @throws \InvalidArgumentException
   */
  private function getFixtures(array $fixtureComponents)
  {
    $fixtures = array();
    foreach ($fixtureComponents as $component) {
      if (!($component instanceof \Neducatio\TestBundle\DataFixtures\FixtureComponent)) {
        throw new \InvalidArgumentException('Elements of given array should be instance of FixtureComponent');
      }
      $fixtures[] = $component->getFixture();
    }

    return $fixtures;
  }
}
