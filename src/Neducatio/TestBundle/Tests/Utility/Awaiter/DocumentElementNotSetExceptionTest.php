<?php

namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\DocumentElementNotSetException;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter\DocumentElementNotSet
 */
class DocumentElementNotSetExceptionTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Tests constructor
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\DocumentElementNotSetException', new DocumentElementNotSetException());
  }
}