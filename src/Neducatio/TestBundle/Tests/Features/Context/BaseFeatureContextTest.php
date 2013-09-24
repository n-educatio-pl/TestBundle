<?php
namespace Neducatio\TestBundle\Tests\Features\Context;

use Neducatio\TestBundle\Tests\Features\Context\FakeContext\TestableBaseFeatureContext;

/**
 * Tests
 *
 * @covers Neducatio\TestBundle\Features\Context\BaseFeatureContext
 */
class BaseFeatureContextTest extends \PHPUnit_Framework_TestCase
{
  private $feature;

  /**
   * Sets up
   */
  public function setUp()
  {
    $this->feature = new TestableBaseFeatureContext(array());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Features\Context\BaseFeatureContext', $this->feature);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function usingJs_called_shouldReturnFalse()
  {
    $this->assertFalse($this->feature->usingJs());
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function usingJs_calledAfterEnablingJs_shouldReturnTrue()
  {
    $this->feature->enableJs();
    $this->assertTrue($this->feature->usingJs());
  }
}
