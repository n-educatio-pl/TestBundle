<?php

namespace Neducatio\TestBundle\Tests\Utility\PHPUnit;

use Neducatio\TestBundle\Utility\PHPUnit\PHPUnitRunner;

/**
 * Tests
 *
 * @covers Neducatio\TestBundle\Utility\PHPUnit\PHPUnitRunner
 */
class PHPUnitRunnerShould extends \PHPUnit_Framework_TestCase
{
  /**
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Given test class does not exists
   */
  public function throwExceptionIfTestClassDoesNotExists()
  {
    new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\NotExistingTest');
  }

  /**
   * @test
   */
  public function createIntanceIfTestClassExists()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $this->assertInstanceOf('Neducatio\TestBundle\Utility\PHPUnit\PHPUnitRunner', $phpunitRunner);
  }

  /**
   * @test
   */
  public function returnTestObject()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $this->assertInstanceOf('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest', $phpunitRunner->getTestCase());
  }

  /**
   * @test
   */
  public function callSetupBeforeRunTest()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $phpunitRunner->run('checkIfTrueEqualsTrue');

    $callStack = $phpunitRunner->getTestCase()->getCallStack();
    $this->assertSame('setUp', $callStack[0]);
  }

  /**
   * @test
   */
  public function runTestAfterSetup()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $phpunitRunner->run('checkIfTrueEqualsTrue');

    $callStack = $phpunitRunner->getTestCase()->getCallStack();
    $this->assertSame('test', $callStack[1]);
  }

  /**
   * @test
   */
  public function callTearDownAfterTest()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $phpunitRunner->run('checkIfTrueEqualsTrue');

    $callStack = $phpunitRunner->getTestCase()->getCallStack();
    $this->assertSame('tearDown', $callStack[2]);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Given test method does not exists
   */
  public function throwExceptionIfTestCaseMethodDoesNotExists()
  {
    $phpunitRunner = new PHPUnitRunner('Neducatio\TestBundle\Tests\Utility\PHPUnit\SampleTest');

    $phpunitRunner->run('notExistingMethod');
  }
}

