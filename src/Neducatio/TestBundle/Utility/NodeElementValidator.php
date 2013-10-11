<?php

namespace Neducatio\TestBundle\Utility;

use \Neducatio\TestBundle\PageObject\InvalidSubPageException;

/**
 * Validates node element
 */
class NodeElementValidator extends Validator
{

  protected function getException()
  {
    return new InvalidSubPageException();
  }

  /**
   * Do sth.
   *
   * @return boolean True if yes
   */
  protected function isCorrectPageReady()
  {
    return $this->isProofSelectorFound();
  }
}