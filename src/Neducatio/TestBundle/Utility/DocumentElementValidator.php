<?php

namespace Neducatio\TestBundle\Utility;

use \Neducatio\TestBundle\PageObject\InvalidPageException;
use \Behat\Mink\Element\DocumentElement;

/**
 * Validates document element
 */
class DocumentElementValidator extends Validator
{

  protected function getException()
  {
    return new InvalidPageException();
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  protected function isCorrectPageReady()
  {
    return $this->isProofSelectorFound() && $this->isEndingHtmlTagFound();
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  protected function isEndingHtmlTagFound()
  {
    return strpos($this->element->getContent(), '</html>') !== false;
  }
}