<?php

namespace Acme\AnimalBundle\Features\Context;

use Neducatio\TestBundle\Features\Context\BaseSubContext;
use Behat\Behat\Exception\PendingException;

/**
 * Feature context.
 */
class TomAndJerryContext extends BaseSubContext
{
  /**
   * @Given /^cat Tom$/
   */
  public function loadTom()
  {
    $fixtures = array(
      \Acme\AnimalBundle\DataFixtures\ORM\LoadTomAnimalData::NAME,
    );
    $this->loadFixtures($fixtures);
  }
  
  /**
   * @When /^Tom eats Jerry$/
   */
  public function tomEatsJerry()
  {
    throw new PendingException();
  }

  /**
   * @Then /^Jerry is no more\.\.\.$/
   */
  public function jerryIsNoMore()
  {
    throw new PendingException();
  }

  
}