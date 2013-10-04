<?php
namespace Neducatio\TestBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Neducatio\TestBundle\PageObject\PageObjectBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Feature context.
 */
abstract class BaseSubContext extends BehatContext
{
  protected $kernel;
  protected $parameters;
  protected $builder;
  protected static $page = null;

  /**
   * Initializes context with symfony kernel
   *
   * @param Symfony\Component\HttpKernel\KernelInterface $kernel symfony kernel
   */
  public function __construct(KernelInterface $kernel)
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
   * Load fixtures
   *
   * @param array $fixtures Array with fixture namespaces
   */
  public function loadFixtures($fixtures)
  {
    $this->checkIfHasParent();
    $this->getMainContext()->loadFixtures($fixtures);
  }

  /**
   * Get reference
   *
   * @param string $reference Reference name
   *
   * @return object
   */
  public function getReference($reference)
  {
    $this->checkIfHasParent();

    return $this->getMainContext()->getReference($reference);
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

  private function checkIfHasParent()
  {
    if ($this->getMainContext() instanceof $this) {
      throw new \RuntimeException("Sub context has no parent");
    }
  }

  private function getBrowserPage()
  {
    return $this->getMainContext()->getSession()->getPage();
  }
}