<?php

namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\Registry;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Registry
 */
class RegistryAccessMethodShould extends \PHPUnit_Framework_TestCase
{
  private $registry;
  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->registry = new Registry();
    $this->registry->set('someExistingKey', 'someExistingValue');
    $this->registry->set('keyWithNullValueSet', null);
  }

  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function setValueUnderGivenKeyWhenBothKeyAndValuePassed()
  {
    $this->assertNull($this->registry->get('someKey'));

    $this->registry->access('someKey', 'someValue');

    $this->assertSame('someValue', $this->registry->get('someKey'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function returnValueThatJustHasBeenSet()
  {
    $this->assertNull($this->registry->get('someKey'));

    $result = $this->registry->access('someKey', 'someValue');

    $this->assertSame('someValue', $result);
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function overwriteValueUnderGivenKeyWhenBothKeyAndValuePassed()
  {
    $this->assertSame('someExistingValue', $this->registry->get('someExistingKey'));

    $this->registry->access('someExistingKey', 'someNewValue');

    $this->assertSame('someNewValue', $this->registry->get('someExistingKey'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function setToNullValueUnderGivenKeyWhenKeyAndNullValuePassed()
  {
    $this->assertSame('someExistingValue', $this->registry->get('someExistingKey'));

    $this->registry->access('someExistingKey', null);

    $this->assertSame(null, $this->registry->get('someExistingKey'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function getValueUnderGivenKeyWhenOnlyKeyPassed()
  {
    $this->assertSame('someExistingValue', $this->registry->get('someExistingKey'));

    $this->assertSame('someExistingValue', $this->registry->access('someExistingKey'));
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function leftValueUnderGivenKeyUnchangedWhenOnlyKeyPassed()
  {
    $this->assertSame('someExistingValue', $this->registry->get('someExistingKey'));

    $this->assertSame('someExistingValue', $this->registry->access('someExistingKey'));

    $this->assertSame('someExistingValue', $this->registry->get('someExistingKey'));
  }
  /**
   * Do sth.
   *
   * @test
   * @expectedException \RuntimeException
   * @expectedExceptionMessage not found
   */
  public function throwExceptionIfValueUnderGivenKeyNotFound()
  {
    $this->assertSame('defaultReturnIndicatingThatValueNotSet', $this->registry->get('emptyKey', 'defaultReturnIndicatingThatValueNotSet'));

    $this->registry->access('emptyKey');
  }
  /**
   * Do sth.
   *
   * @test
   */
  public function NOTThrowExceptionIfValueUnderGivenKeyHappensToBeNull()
  {
    $this->assertNull($this->registry->get('keyWithNullValueSet', 'defaultReturnIndicatingThatValueNotSet'));

    $this->registry->access('keyWithNullValueSet');
  }
}