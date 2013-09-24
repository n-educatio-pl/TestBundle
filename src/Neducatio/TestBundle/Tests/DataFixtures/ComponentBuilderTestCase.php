<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\ComponentBuilder;
use Mockery as m;

/**
 * Do sth.
 *
 * @group integration
 *
 * @covers Neducatio\TestBundle\DataFixtures\ComponentBuilder
 */
abstract class ComponentBuilderTestCase extends \PHPUnit_Framework_TestCase
{
  protected $container;
  protected $builder;
  protected $loadableClasses = array();
  /**
   * Do sth.
   */
  public function setUp()
  {
    $this->container = m::mock('\Symfony\Component\DependencyInjection\ContainerInterface');
    $this->builder = new ComponentBuilder($this->container);
    $this->loadableClasses['P'] = 'Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\P';
    $this->loadableClasses['X'] = 'Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\X';
    $this->loadableClasses['Y'] = 'Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\Y';
    $this->loadableClasses['Z'] = 'Neducatio\TestBundle\Tests\DataFixtures\FakeFixture\Z';
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
  public function __construct_shouldCreateInstance()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\ComponentBuilder', $this->builder);
  }
}
