<?php

namespace Neducatio\TestBundle\Utility;

use \Neducatio\TestBundle\PageObject\InvalidPageException;
use \Behat\Mink\Element\DocumentElement;

/**
 * Validates document element
 */
class DocumentElementValidator
{
  protected $documentElement;
  protected $proofSelector;
  protected $proofSelectorVisibility;

  /**
   * Do sth.
   *
   * @param DocumentElement $documentElement         Document element - page
   * @param string          $proofSelector           Proof selector
   * @param boolean         $proofSelectorVisibility Proof selector visibillity
   * 
   * @throws InvalidPageException
   */
  public function validate(DocumentElement $documentElement, $proofSelector, $proofSelectorVisibility = false)
  {
    $this->documentElement = $documentElement;
    $this->proofSelector = $proofSelector;
    $this->proofSelectorVisibility = $proofSelectorVisibility;
    $before = time();
    while (!$this->isCorrectPageReady()) {
      if ((time() - $before) < 5) {
        usleep(100000); // 0.1 second
        continue;
      }
      usleep(500000);
      throw new InvalidPageException();
    }
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  private function isCorrectPageReady()
  {
    return $this->isProofSelectorFound() && $this->isEndingHtmlTagFound();
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  private function isProofSelectorFound()
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
  private function isAnyOfElementsVisible(array $elements)
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
  private function getAllProofElements()
  {
    return $this->documentElement->findAll('css', $this->proofSelector);
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  private function isEndingHtmlTagFound()
  {
    return strpos($this->documentElement->getContent(), '</html>') !== false;
  }
}