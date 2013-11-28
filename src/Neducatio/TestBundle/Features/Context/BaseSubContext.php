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
  const PAGE_KEY = 'page';
  const FIXTURES_KEY = 'fixtures';

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
   * Add fixture to load
   *
   * @param string $fixture Fixture to add
   */
  public function addFixture($fixture)
  {
    $this->getRegistry()->add(self::FIXTURES_KEY, $fixture);
  }
  /**
   * Load fixtures
   *
   * @param array $fixtures Array with fixture namespaces
   */
  public function loadFixtures($fixtures = null)
  {
    if ($fixtures == null) {
      $fixtures = $this->getRegistry()->get(self::FIXTURES_KEY);
    }
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
   * Get page object from registry
   *
   * @return PageObject
   * @deprecated
   */
  public function getPage()
  {
    return $this->getRegistry()->get(self::PAGE_KEY);
  }

  /**
   * Set page object
   *
   * @param type $pageObjectName Page object
   *
   * @deprecated
   */
  public function setPage($pageObjectName)
  {
      $this->setPageByName($pageObjectName);
  }
    /**
     * Set page object
     *
     * @param type $pageObjectName Page object
     */
    public function setPageByName($pageObjectName)
    {
        $this->getRegistry()->set(self::PAGE_KEY, $this->builder->build($pageObjectName, $this->getBrowserPage()));
    }
  /**
   * Retrieves or sets page object in registry. If no value passed only gets page object from registry.
   *
   * @param mixed $pageObject Page object to set (optional)
   *
   * @return \Neducatio\TestBundle\PageObject\BasePageObject
   */
  public function page($pageObject = null)
  {
    if (func_num_args() > 0) {
      return $this->getRegistry()->access(self::PAGE_KEY, $pageObject);
    }

    return $this->getRegistry()->access(self::PAGE_KEY);
  }

  /**
   * @throws \RuntimeException
   *
   * @return \Neducatio\TestBundle\Utility\Registry
   */
  public function getRegistry()
  {
    return $this->getMainContext()->getRegistry();
  }

  /**
   * Get main context or throw exception if not set
   *
   * @throws \RuntimeException
   *
   * @return BaseFeatureContext
   */
  public function getMainContext()
  {
      if (parent::getMainContext() instanceof $this) {
        throw new \RuntimeException("Sub context has no parent");
      }

      return parent::getMainContext();
  }

  /**
   * @throws \RuntimeException
   *
   * @return DocumentElement
   */
  private function getBrowserPage()
  {
    return $this->getMainContext()->getSession()->getPage();
  }
}