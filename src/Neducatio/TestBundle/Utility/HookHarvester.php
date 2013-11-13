<?php

namespace Neducatio\TestBundle\Utility;

use \Behat\Mink\Element\TraversableElement;
use \Neducatio\TestBundle\PageObject\PageObjectBuilder;
use \Neducatio\TestBundle\PageObject\BasePageObject;

/**
 * Description of HookHarvester
 */
class HookHarvester
{
  private $register = array();
  private $builder;

  /**
   * Constructor
   *
   * @param \Neducatio\TestBundle\PageObject\PageObjectBuilder $builder Builder
   */
  public function __construct(PageObjectBuilder $builder)
  {
    $this->builder = $builder;
  }
  /**
   * Registers Hooks
   *
   * @param BasePageObject $pageObject PageObject witch harvest
   */
  public function registerHooks(BasePageObject $pageObject)
  {
    $this->register($pageObject, $pageObject->getProofSelector());
  }
  /**
   * Registers Hooks
   *
   * @param BasePageObject $pageObject PageObject witch harvest
   */
  public function registerHooksFromPrompt(BasePageObject $pageObject)
  {
    $this->register($pageObject, '.ui-dialog-content');
  }

  protected function register(BasePageObject $pageObject, $proofSelector)
  {
    $elements = $this->getNodeElements($pageObject->getPageElement(), $proofSelector);
    foreach ($elements as $element) {
      $this->addElement($element, $pageObject);
    }
  }

  /**
   * Gets hook by key.
   *
   * @param string  $key   Key under which the node exists in register.
   * @param integer $place Index of given node (if exists many nodes with the same key)
   *
   * @return NodeElement Node of given key
   */
  public function get($key, $place = 0)
  {
    if (!array_key_exists($key, $this->register)) {
      throw new \InvalidArgumentException('Hook ' . $key . ' not found.');
    }

    return $this->register[$key][$place];
  }

  /**
   * Check if hook exists
   *
   * @param string $key Key hook to check
   *
   * @return bool
   */
  public function has($key)
  {
    return array_key_exists($key, $this->register);
  }

  /**
   * Retrieve harvest
   *
   * @param TraversableElement $page          Page
   * @param string             $proofSelector Proof selector
   *
   * @return NodeElement
   *
   * @throws \InvalidArgumentException
   */
  private function retrieveHarvest(TraversableElement $page, $proofSelector)
  {
    $harvest = $page->find('css', $proofSelector);
    if ($harvest === null) {
      throw new \InvalidArgumentException('Proof selector not found.');
    }

    return $harvest;
  }

  /**
   * Gets node elements
   *
   * @param TraversableElement $page          Page
   * @param string             $proofSelector Proof selector
   *
   * @return array
   */
  private function getNodeElements(TraversableElement $page, $proofSelector)
  {
    $harvest = $this->retrieveHarvest($page, $proofSelector);

    return $harvest->findAll('xpath', "//*[contains(@class, 't_')]");
  }

  /**
   * Gets keys for element
   *
   * @param TraversableElement $element    Element
   * @param BasePageObject     $pageObject PageObject witch harvest
   */
  private function addElement(TraversableElement $element, BasePageObject $pageObject)
  {
    foreach ($this->retrieveClassesForElement($element) as $key) {
      $this->register[$key][] = $this->getElementToRegister($element, $key, $pageObject);
    }
  }

  /**
   * Returns page element or subpage element if exists for given class selector
   *
   * @param \Behat\Mink\Element\TraversableElement          $element    Page element
   * @param string                                          $class      Element class
   * @param \Neducatio\TestBundle\PageObject\BasePageObject $pageObject Page object
   *
   * @return TraversableElement
   */
  private function getElementToRegister(TraversableElement $element, $class, BasePageObject $pageObject)
  {
      $elementToRegister = $element;
      $subpageObjectsdata = $pageObject->getSubPageObjectsData();
      if (array_key_exists($class, $subpageObjectsdata)) {
          $elementToRegister = $this->builder->build($subpageObjectsdata[$class], $element, $pageObject);
      }

      return $elementToRegister;
  }

  /**
   * Retrieves classes for element
   *
   * @param type $element NodeElement
   *
   * @return array without t_ already
   */
  private function retrieveClassesForElement($element)
  {
    $classes = $element->getAttribute('class');
    $matches = array();
    preg_match_all('/t_([a-zA-Z0-9\_]+)/', $classes, $matches);

    return $matches[1];
  }

  /**
   * Gets register
   *
   * @return array
   */
  public function getRegister()
  {
    return $this->register;
  }
}