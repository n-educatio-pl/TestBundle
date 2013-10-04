<?php

namespace Neducatio\TestBundle\PageObject;

use Behat\Mink\Element\DocumentElement;
use Neducatio\TestBundle\Utility\DocumentElementValidator;
use Neducatio\TestBundle\Utility\HookHarvester;
use Neducatio\TestBundle\Utility\Awaiter\PageAwaiter;

/**
 * Page object builder
 */
class PageObjectBuilder
{
  private $validator;
  private $harvester;
  private $awaiter;

  /**
   * Creates dependencies
   */
  public function __construct()
  {
    $this->validator = new DocumentElementValidator();
    $this->harvester = new HookHarvester();
    $this->awaiter = new PageAwaiter();
  }

  /**
   * Builds
   *
   * @param string          $page    Page
   * @param DocumentElement $element Document element
   *
   * @return instance of page
   */
  public function build($page, DocumentElement $element)
  {
    $this->awaiter->setPage($element);

    return new $page($element, $this);
  }

  /**
   * Gets validator
   *
   * @return DocumentElementValidator
   */
  public function getValidator()
  {
    return $this->validator;
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
