<?php
namespace Acme\AnimalBundle\Features\Context;

use Neducatio\TestBundle\Features\Context\BaseFeatureContext;
use Neducatio\TestBundle\PageObject\PageObjectBuilder;

/**
 * Feature context.
 */
class FeatureContext extends BaseFeatureContext
{
  /**
   * Initializes context with parameters from behat.yml.
   *
   * @param array $parameters Parameters
   */
  public function __construct(array $parameters)
  {
    parent::__construct($parameters);
    $parameters['builder'] = new PageObjectBuilder();
//    $landingContext = new LandingContext($parameters);
//    $this->useContext('landing_context', $landingContext);
  }
}
