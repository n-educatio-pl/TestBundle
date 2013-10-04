<?php

namespace Neducatio\TestBundle\Utility\Awaiter;

/**
 * Description of Awaiter
 */
class Awaiter extends AwaiterBase
{
  protected $page = null;

  /**
   * Set page
   *
   * @param \Behat\Mink\Element\DocumentElement $page Page
   */
  public function setPage(\Behat\Mink\Element\DocumentElement $page)
  {
    $this->page = $page;
  }

  /**
   * Wait until element will be visible on page
   *
   * @param string $selector Element selector
   * @param string $type     Selector type
   *
   * @return null (closure returns bool, not this function)
   *
   * @throws DocumentElementNotSetException
   */
  public function waitUntilVisible($selector, $type = 'css')
  {
    if ($this->page === null) {
      throw new DocumentElementNotSetException();
    }
    $page = $this->page;
    $this->waitUntilTrue(function() use ($page, $selector, $type) {
      return $page->find($type, $selector) !== null && $page->find($type, $selector)->isVisible();
    });
  }

  /**
   * Wait until element disappear from page
   *
   * @param string $selector Element selector
   * @param string $type     Selector type
   *
   * @return null (closure returns bool, not this function)
   *
   * @throws DocumentElementNotSetException
   */
  public function waitUntilDisappear($selector, $type = 'css')
  {
    if ($this->page === null) {
      throw new DocumentElementNotSetException();
    }
    $page = $this->page;
    $this->waitUntilFalse(function() use ($page, $selector, $type) {
      return $page->has($type, $selector);
    });
  }
}