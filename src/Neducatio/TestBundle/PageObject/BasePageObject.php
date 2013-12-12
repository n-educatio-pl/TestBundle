<?php

namespace Neducatio\TestBundle\PageObject;

use Neducatio\TestBundle\Utility\HookHarvester;
use \Behat\Mink\Element\TraversableElement;

/**
 * Base page object
 */
abstract class BasePageObject
{
  protected $builder;
  protected $page;
  protected $proofSelectorVisibility = false;
  protected $proofSelector;
  protected $parent;
  protected $harvester;
  protected $subPageObjectsData = array();
  protected $subPageObjects;

  /**
   * Do sth.
   *
   * @param TraversableElement $page      Page used to instantiate PageObject
   * @param PageObjectBuilder  $builder   Page object builder
   * @param HookHarvester      $harvester Hook harvester for this page
   * @param BasePageObject     $parent    Subpage object parent
   */
  public function __construct(TraversableElement $page, PageObjectBuilder $builder, HookHarvester $harvester, BasePageObject $parent = null)
  {
    $this->page = $page;
    $this->builder = $builder;
    $this->parent = $parent;
    $this->harvester = $harvester;
    $this->builder->getValidator($page)->validate($page, $this->proofSelector, $this->proofSelectorVisibility);
    $this->harvester->registerHooks($this);
  }

  /**
   * Get page element
   *
   * @return TraversableElement
   */
  public function getPageElement()
  {
      return $this->page;
  }

  /**
   * Get proof selector
   *
   * @return string
   */
  public function getProofSelector()
  {
      return $this->proofSelector;
  }

  /**
   * Get SubPageObjectsData
   *
   * @return array
   */
  public function getSubPageObjectsData()
  {
      return $this->subPageObjectsData;
  }

  /**
   * Gets hook
   *
   * @param string  $key   Hook key
   * @param integer $place Index of given node (if exists many nodes with the same key)
   *
   * @return NodeElement
   */
  public function get($key, $place = 0)
  {
    return $this->harvester->get($key, $place);
  }

  /**
   * Gets all hooks by given key
   *
   * @param string $key Hook key
   *
   * @return array
   */
  public function getAllByKey($key)
  {
    return $this->harvester->getAllByKey($key);
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
    return $this->harvester->has($key);
  }

  /**
   * Get Awaiter from Builder
   *
   * @return PageAwaiter
   */
  public function getAwaiter()
  {
    return $this->builder->getAwaiter($this->page);
  }

//  /**
//   * get sub page objects
//   *
//   * @return array
//   */
//  public function getSubPages()
//  {
//    return $this->subPageObjects;
//  }

  /**
   * Get parent
   *
   * @return BasePageObject
   */
  public function getParent()
  {
    return $this->parent;
  }

  /**
   * Build new page object
   *
   * @param string $name page object class name
   *
   * @return BasePageObject
   */
  public function buildPageObjectByName($name)
  {
    return $this->builder->build($name);
  }
}
