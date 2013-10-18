<?php

namespace Neducatio\TestBundle\PageObject;

use Behat\Mink\Element\TraversableElement;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\DocumentElement;
use Neducatio\TestBundle\Utility\DocumentElementValidator;
use Neducatio\TestBundle\Utility\NodeElementValidator;
use Neducatio\TestBundle\Utility\HookHarvester;
use Neducatio\TestBundle\Utility\Awaiter\PageAwaiter;
use Neducatio\TestBundle\Features\Context\BaseFeatureContext;

/**
 * Page and subpage object builder
 */
class PageObjectBuilder
{
  private $nodeValidator;
  private $documentValidator;
  private $harvester;
  private $awaiter;
  private $context;

  /**
   * Creates dependencies
   *
   * @param \Neducatio\TestBundle\Features\Context\BaseFeatureContext $context feature context
   */
  public function __construct(BaseFeatureContext $context)
  {
    $this->nodeValidator = new NodeElementValidator();
    $this->documentValidator = new DocumentElementValidator();
    $this->harvester = new HookHarvester($this);
    $this->awaiter = new PageAwaiter();
    $this->context = $context;
  }

  /**
   * Builds
   *
   * @param string          $page             Page
   * @param DocumentElement $element          Document element
   * @param BasePageObject  $parentPageObject Page object which build new subpage (null if it is main pageobject)
   *
   * @return instance of page
   */
  public function build($page, TraversableElement $element = null, BasePageObject $parentPageObject = null)
  {
    if (class_exists($page)) {
      $element = $this->getCurrentBrowserPage($element);
      $this->awaiter->setPage($element);

      return new $page($element, $this, $parentPageObject);
    } else {
      throw new \InvalidArgumentException("Page class \"{$page}\" doesn't exist");
    }
  }

  private function getCurrentBrowserPage($element = null)
  {
    if ($element === null) {
      if ($this->context->getSession() === null) {
          throw new \RuntimeException("Session not set");
      }
      $element = $this->context->getSession()->getPage();
    }

    return $element;
  }

  /**
   * Gets validator
   *
   * @param TraversableElement $page Validator for given page type will be returned
   *
   * @return TraversableElementValidator
   */
  public function getValidator(TraversableElement $page)
  {
    if ($page instanceof NodeElement) {

        return $this->nodeValidator;
    }

    return $this->documentValidator;
  }

  /**
   * Gets harvester
   *
   * @return HookHarvester
   */
  public function getHarvester()
  {
    return $this->harvester;
  }

  /**
   * Gets awaiter
   *
   * @return PageAwaiter
   */
  public function getAwaiter()
  {
    return $this->awaiter;
  }
}
