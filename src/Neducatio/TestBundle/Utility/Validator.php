<?php

namespace Neducatio\TestBundle\Utility;

use \Neducatio\TestBundle\PageObject\InvalidPageException;
use Behat\Mink\Element\TraversableElement;

/**
 * Validates traversable element
 */
abstract class Validator
{
  protected $element;
  protected $proofSelector;
  protected $proofSelectorVisibility;

  /**
   * Do sth.
   *
   * @param TraversableElement $element                 element - page
   * @param string             $proofSelector           Proof selector
   * @param boolean            $proofSelectorVisibility Proof selector visibillity
   *
   * @throws InvalidPageException
   */
  public function validate(TraversableElement $element, $proofSelector, $proofSelectorVisibility = false)
  {
    $this->element = $element;
    $this->proofSelector = $proofSelector;
    $this->proofSelectorVisibility = $proofSelectorVisibility;
    $before = time();
    while (!$this->isCorrectPageReady()) {
      if ((time() - $before) < 2) {
        usleep(100000); // 0.1 second
        continue;
      }
      throw $this->getException();
    }
    usleep(500000);
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  abstract protected function isCorrectPageReady();

  abstract protected function getException();

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  protected function isProofSelectorFound()
  {
    if ($this->proofSelectorVisibility) {
      return $this->isAnyOfElementsVisible($this->getAllProofElements());
    } else {
      return count($this->getAllProofElements()) > 0;
    }
  }

  /**
   * Do sth.
   *
   * @param array $elements Checked elements
   *
   * @return boolean true if yes
   */
  protected function isAnyOfElementsVisible(array $elements)
  {
    foreach ($elements as $element) {
      if ($element->isVisible()) {
        return true;
      }
    }

    return false;
  }

  /**
   * Do sth.
   *
   * @return array of Elements that meet the proof selector rules.
   */
  protected function getAllProofElements()
  {
    return $this->element->findAll('css', $this->proofSelector);
  }

//  /**
//   * Do sth.
//   *
//   * @return boolean True if yes
//   */
//  private function isEndingHtmlTagFound()
//  {
//    return strpos($this->documentElement->getContent(), '</html>') !== false;
//  }
}