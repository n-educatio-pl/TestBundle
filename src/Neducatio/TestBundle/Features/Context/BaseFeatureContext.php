<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
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
abstract class NBaseFeatureContext extends MinkContext implements KernelAwareInterface
{
  protected $kernel;
  protected $fixtureLoader;
  protected $parameters;
  protected $page;
  protected $registry;
  protected $dependencies;
  protected $usingJs = false;

  /**
   * Initializes context with parameters from behat.yml.
   *
   * @param array $parameters Parameters
   */
  public function __construct(array $parameters)
  {
    $this->registry = new Registry();
    $this->parameters = $parameters;
    $this->dependencies = new FixtureDependencyInvoker($this->kernel);
  }

  /**
   * Sets HttpKernel instance.
   *
   * This method will be automatically called by Symfony2Extension ContextInitializer.
   *
   * @param KernelInterface $kernel Kernel
   */
  public function setKernel(KernelInterface $kernel)
  {
      $this->kernel = $kernel;
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
    $this->fixtureLoader = new FixtureLoader($this->dependencies, $fixtureClasses);
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
