<?php

namespace Neducatio\TestBundle\PageObject;

use \Behat\Mink\Element\DocumentElement;

/**
 * Base page object
 */
abstract class BasePageObject
{
  protected $builder;
  protected $page;
  protected $proofSelectorVisibility = false;

  /**
   * Do sth.
   *
   * @param DocumentElement   $page    Page used to instantiate PageObject
   * @param PageObjectBuilder $builder Page object builder
   */
  public function __construct(DocumentElement $page, PageObjectBuilder $builder)
  {
    $this->page = $page;
    $this->builder = $builder;
    $this->builder->getValidator()->validate($page, $this->proofSelector, $this->proofSelectorVisibility);
    $this->builder->getHarvester()->registerHooks($page, $this->proofSelector);
  }

  /**
   * Gets hook
   *
   * @param string $key Hook key
   *
   * @return NodeElement
   */
  public function get($key)
  {
    return $this->builder->getHarvester()->get($key);
  }
}
