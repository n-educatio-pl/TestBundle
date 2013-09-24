<?php

namespace Neducatio\TestBundle\Tests\DataFixtures;

use Neducatio\TestBundle\DataFixtures\FixtureExecutor;
use Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\DataFixtures\FixtureExecutor
 */
class FixtureExecutorTest extends \PHPUnit_Framework_TestCase
{
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
  public function __construct_shouldCreateInstanceOfFixtureExecutor()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\DataFixtures\FixtureExecutor', $this->getFixtureExecutor());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage There is no fixtures components to execute
   */
  public function execute_calledWithEmptyFixturesArray_shouldThrowException()
  {
    $this->getFixtureExecutor()->execute(array());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Elements of given array should be instance of FixtureComponent
   */
  public function execute_calledWithNoFixtureComponentArray_shouldThrowException()
  {
    $this->getFixtureExecutor()->execute(array(1, 2));
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function execute_calledWithOneFixtureComponent_shouldCallExecuteWithOneFixtureOnOrmExecutor()
  {
    $fixtureComponents = array(
      $this->getFakeFixtureComponent(),
    );
    $fixtures = array(
      $fixtureComponents[0]->getFixture(),
    );
    $ormExecutor = $this->getORMExecutor();
    $ormExecutor->shouldReceive('execute')->with($fixtures)->once();
    $this->getFixtureExecutor($ormExecutor)->execute($fixtureComponents);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function execute_calledWithFourFixturesComponents_shouldCallExecuteWithFourFixturesOnOrmExecutorInTheSameOrder()
  {
    $fixtureComponents = array(
      $this->getFakeFixtureComponent(),
      $this->getFakeFixtureComponent(),
      $this->getFakeFixtureComponent(),
      $this->getFakeFixtureComponent(),
    );
    $fixtures = array(
      $fixtureComponents[0]->getFixture(),
      $fixtureComponents[1]->getFixture(),
      $fixtureComponents[2]->getFixture(),
      $fixtureComponents[3]->getFixture(),
    );
    $ormExecutor = $this->getORMExecutor();
    $ormExecutor->shouldReceive('execute')->with($fixtures)->once();
    $this->getFixtureExecutor($ormExecutor)->execute($fixtureComponents);
  }

  /**
   * Get FixtureComponent mock
   *
   * @return FixtureComponent mock
   */
  private function getFakeFixtureComponent()
  {
    $fixtureComponent = m::mock('\Neducatio\TestBundle\DataFixtures\FixtureComponent');
    $fixtureComponent->shouldReceive('getFixture')->andReturn(get_class($fixtureComponent));

    return $fixtureComponent;
  }

  /**
   * Get fake ORMExecutor
   *
   * @return ORMExecutor mock
   */
  private function getORMExecutor()
  {
    return m::mock('\Doctrine\Common\DataFixtures\Executor\AbstractExecutor');
  }

  /**
   * Get fixture executor
   *
   * @param AbstractExecutor $ormExecutor ORM Executor
   *
   * @return FixtureExecutor
   */
  private function getFixtureExecutor($ormExecutor = null)
  {
    if ($ormExecutor === null) {
      $ormExecutor = $this->getORMExecutor();
    }

    return new FixtureExecutor($ormExecutor);
  }
}