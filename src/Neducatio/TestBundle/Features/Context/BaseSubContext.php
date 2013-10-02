<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Neducatio\TestBundle\DataFixtures\FixtureLoader;
use Neducatio\TestBundle\DataFixtures\FixtureDependencyInvoker;
use Neducatio\TestBundle\PageObject\PageObjectBuilder;

/**
 * Feature context.
 */
abstract class BaseSubContext extends BehatContext
{
  protected $kernel;
  protected $fixtureLoader;
  protected $parameters;
  protected $builder;
  protected static $page = null;

  /**
   * Initializes context with symfony kernel
   *
   * @param Symfony\Component\HttpKernel\KernelInterface $kernel symfony kernel
   */
  public function __construct($kernel)
  {
      $this->kernel = $kernel;
      $this->builder = null;
  }

  /**
   * Set page object builder
   *
   * @param \Neducatio\TestBundle\PageObject\PageObjectBuilder $builder page object builder
   */
  public function setBuilder(PageObjectBuilder $builder)
  {
      $this->builder = $builder;
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
   * Translate given message, optional array with parameters and lang for translation
   *
   * @param string $message    Message to translate
   * @param array  $parameters Parameters for translation
   * @param string $lang       Language for translation (default pl)
   *
   * @return string
   */
  public function translate($message, array $parameters = array(), $lang = 'pl')
  {
    $translator = $this->kernel->getContainer()->get('translator');

    return $translator->trans($message, $parameters, 'messages', $lang);
  }

  /**
   * Get page object
   *
   * @return type
   */
  public function getPage()
  {
    return self::$page;
  }

  /**
   * Set page object
   *
   * @param type $pageObjectName Page object
   */
  public function setPage($pageObjectName)
  {
    self::$page = $this->builder->build($pageObjectName, $this->getBrowserPage());
  }

  private function getBrowserPage()
  {
    return $this->getMainContext()->getSession()->getPage();
  }
}