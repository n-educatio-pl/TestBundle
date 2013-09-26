<?php

namespace Acme\AnimalBundle\Features\Context;

use Neducatio\TestBundle\Features\Context\BaseSubContext;

/**
 * Feature context.
 */
class TomAndJerryContext extends BaseSubContext
{
  /**
   * @Given /^cat Tom and alive mouse Jerry$/
   */
  public function loadTomAndJerry()
  {
    $fixtures = array(
      \Acme\AnimalBundle\DataFixtures\ORM\LoadTomAnimalData::NAME,
    );
    $this->loadFixtures($fixtures);
    assertTrue($this->getReference('animalJerry')->isAlive());
  }

  /**
   * @When /^Tom eats Jerry$/
   */
  public function tomEatsJerry()
  {
    $this->getReference('animalTom')->eatToy();
  }

  /**
   * @Then /^Jerry is no more\.\.\.$/
   */
  public function jerryIsNoMore()
  {
    assertFalse($this->getReference('animalJerry')->isAlive());
  }


}