<?php

namespace Neducatio\TestBundle\Tests\Utility;

use \Neducatio\TestBundle\Utility\NodeElementValidator;

use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\NodeElementValidator
 * @covers Neducatio\TestBundle\Utility\Validator
 */
class NodeElementValidatorTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Do sth
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\Utility\NodeElementValidator', $this->getValidator());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException \Neducatio\TestBundle\PageObject\InvalidSubPageException
   */
  public function validate_nodeWithoutProofSelectors_shouldThrowException()
  {
    $page = $this->getMainNodeElement(array());
    $this->getValidator()->validate($page, 'any-selector');
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException \Neducatio\TestBundle\PageObject\InvalidSubPageException
   */
  public function validate_pageWithInvisibleProofSelectors_shouldThrowException()
  {
    $proofSelectors = array($this->getNodeElement(false));
    $page = $this->getMainNodeElement($proofSelectors);
    $this->getValidator()->validate($page, 'any-selector', true);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function validate_pageWithVisibleProofSelectors_shouldCreateInstance()
  {
    $page = $this->getMainNodeElement();
    $this->getValidator()->validate($page, 'any-selector', true);
  }

  /**
   * Gets node element
   *
   * @param bool $visiblity Vsibility of the node element
   *
   * @return NodeElement
   */
  private function getNodeElement($visiblity)
  {
    $node = m::mock('\Behat\Mink\Element\NodeElement');
    $node->shouldReceive('isVisible')->andReturn($visiblity);

    return $node;
  }

  /**
   * Gets node element
   * 
   * @param type $selectors Selectors
   * 
   * @return type
   */
  private function getMainNodeElement($selectors = null)
  {
    if ($selectors === null) {
      $selectors = array($this->getNodeElement(true));
    }

    $session = m::mock('\stdClass');
    $session->shouldReceive('wait');

    $page = m::mock('\Behat\Mink\Element\NodeElement');
    $page->shouldReceive('findAll')->andReturn($selectors);
    $page->shouldReceive('getSession')->andReturn($session);

    return $page;
  }

  /**
   * Gets validator
   * 
   * @return DocumentElementValidator
   */
  private function getValidator()
  {
    return new NodeElementValidator();
  }
}