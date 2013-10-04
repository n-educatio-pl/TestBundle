<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\BehatBundle\Context\MinkContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Neducatio\TestBundle\DataFixtures\FixtureLoader;
use Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker;
use Neducatio\TestBundle\Utility\Registry;

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
  protected $fixtureLoader;
  protected $page;
  protected $registry;
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
    $this->registry = new Registry();
  }

  /**
   * Get registry
   *
   * @return Registry
   */
  public function getRegistry()
  {
    return $this->registry;
  }

  /**
   * Loads fixtures to test database.
   * If you want to run test using browser, you must point prod DB to test DB.
   *
   * @param array $fixtureClasses Fixture classes namespaces
   */
  public function loadFixtures(array $fixtureClasses)
  {
    $dependencies = new FixtureDependencyInvoker($this->kernel);
    $this->fixtureLoader = new FixtureLoader($dependencies, $fixtureClasses);
    $this->fixtureLoader->load();
  }

  /**
   * Gets Reference
   *
   * @param string $reference Reference's name
   *
   * @throws \RuntimeException
   *
   * @return object Reference to object
   */
  public function getReference($reference)
  {
    if ($this->fixtureLoader === null) {
      throw new \RuntimeException('Fixtures are not loaded');
    }

    return $this->fixtureLoader->getReference($reference);
  }

  /**
   * Enables JS in scenario with tag javascript
   *
   * @BeforeScenario @mink:selenium2
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
