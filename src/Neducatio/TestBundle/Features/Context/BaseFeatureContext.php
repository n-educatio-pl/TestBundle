<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\BehatBundle\Context\MinkContext;

// @codeCoverageIgnoreStart
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
// @codeCoverageIgnoreEnd

/**
 * Feature context.
 */
abstract class BaseFeatureContext extends MinkContext
{
  protected $kernel;
  protected $page;
  protected $usingJs = false;

  /**
   * Initializes context with parameters from behat.yml.
   *
   * @param Kernel $kernel Symfony kernel
   */
  public function __construct($kernel)
  {
    parent::__construct($kernel);
    $this->kernel = $kernel;
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
