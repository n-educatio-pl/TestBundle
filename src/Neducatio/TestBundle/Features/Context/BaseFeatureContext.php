<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;

// @codeCoverageIgnoreStart
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
// @codeCoverageIgnoreEnd

/**
 * Feature context.
 */
abstract class BaseFeatureContext extends MinkContext
{
  protected $parameters;
  protected $page;
  protected $usingJs = false;

  /**
   * Initializes context with parameters from behat.yml.
   *
   * @param array $parameters Parameters
   */
  public function __construct(array $parameters)
  {
    $this->parameters = $parameters;
  }

  /**
   * Enables JS in scenario with tag javascript
   *
   * @BeforeScenario @javascript
   */
  public function enableJs()
  {
    $this->usingJs = true;
  }

  /**
   * Returns true if scenario uses javascript tag.
   *
   * @return boolean
   */
  public function usingJs()
  {
    return $this->usingJs;
  }
}
