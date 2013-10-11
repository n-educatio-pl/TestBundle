<?php

namespace Neducatio\TestBundle\Utility;

use \Behat\Mink\Element\TraversableElement;
use \Neducatio\TestBundle\PageObject\PageObjectBuilder;

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
  public function registerHooks(\Neducatio\TestBundle\PageObject\BasePageObject $pageObject)
  {
    $elements = $this->getNodeElements($pageObject->getPageElement(), $pageObject->getProofSelector());
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
   * @param NodeElement    $element    Element
   * @param BasePageObject $pageObject PageObject witch harvest
   */
  private function addElement($element, \Neducatio\TestBundle\PageObject\BasePageObject $pageObject)
  {
    $subPageObjectsData = $pageObject->getSubPageObjectsData();
    foreach ($this->retrieveClassesForElement($element) as $key) {
      $elementToRegister = $element;
      if (array_key_exists($key, $subPageObjectsData)) {
          $elementToRegister = $this->builder->build($subPageObjectsData[$key], $element, $pageObject);
      }
      $this->register[$key][] = $elementToRegister;
    }
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
    preg_match_all('/t_([a-z0-9\_]+)/', $classes, $matches);

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