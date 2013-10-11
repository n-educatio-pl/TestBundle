<?php

namespace Neducatio\TestBundle\Utility;

use \Behat\Mink\Element\TraversableElement;

/**
 * Description of HookHarvester
 */
class HookHarvester
{
  private $register = array();

  /**
   * Registers Hooks
   *
   * @param TraversableElement $page          Page
   * @param string             $proofSelector Proof selector
   */
  public function registerHooks(TraversableElement $page, $proofSelector)
  {
    $elements = $this->getNodeElements($page, $proofSelector);
    foreach ($elements as $element) {
      $this->addElement($element);
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
   * @param NodeElement $element Element
   */
  private function addElement($element)
  {
    foreach ($this->retrieveClassesForElement($element) as $key) {
      $this->register[$key][] = $element;
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