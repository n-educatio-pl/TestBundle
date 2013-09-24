<?php

namespace Neducatio\TestBundle\Tests\PageObject;

use Neducatio\TestBundle\PageObject\BasePageObject;

/**
 * Testable base page object
 */
class TestableBasePage extends BasePageObject
{
  const NAME = __CLASS__;
  protected $proofSelector = 'selector';
}
