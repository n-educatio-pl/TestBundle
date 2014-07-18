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
    $this->awaiter = new PageAwaiter();
    $this->context = $context;
  }

  /**
   * Builds page objects
   *
   * @param string             $page             Page
   * @param TraversableElement $element          Document element
   * @param BasePageObject     $parentPageObject Page object which build new subpage (null if it is main pageobject)
   *
   * @return BasePageObject
   *
   * @throws \InvalidArgumentException
   */
  public function build($page, TraversableElement $element = null, BasePageObject $parentPageObject = null)
  {
    if (class_exists($page)) {
      $element = $this->getCurrentBrowserPage($element);
      $harvester = new HookHarvester($this);

      return new $page($element, $this, $harvester, $parentPageObject, $this->context->getSession());
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
   * Gets awaiter
   *
   * @param TraversableElement $element Root element to be searched by awaiter
   *
   * @return PageAwaiter
   */
  public function getAwaiter(TraversableElement $element)
  {
    $this->awaiter->setPage($element);

    return $this->awaiter;
  }

  /**
   * Setter
   *
   * @param PageAwaiter $awaiter Awaiter
   */
  public function setAwaiter(PageAwaiter $awaiter)
  {
      $this->awaiter = $awaiter;
  }
}
