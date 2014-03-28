<?php

namespace Neducatio\TestBundle\Utility\PHPUnit;

/**
 * PHPUnit test runner
 */
class PHPUnitRunner
{
  private $testCase;

  /**
   * Prepare test case object
   *
   * @param string $testClassNamespace Test class namespace
   *
   * @throws \InvalidArgumentException
   */
  public function __construct($testClassNamespace)
  {
    if (!class_exists($testClassNamespace)) {
      throw new \InvalidArgumentException('Given test class does not exist');
    }

    $this->testCase = new $testClassNamespace;

    if (!($this->testCase instanceof \PHPUnit_Framework_TestCase)) {
      throw new \InvalidArgumentException('Given test class does not extend \PHPUnit_Framework_TestCase');
    }
  }

  /**
   * Get test case
   *
   * @return object
   */
  public function getTestCase()
  {
    return $this->testCase;
  }

  /**
   * Run test
   *
   * @param string $method Test name
   *
   * @throws \InvalidArgumentException
   */
  public function run($method)
  {
    if (!method_exists($this->testCase, $method)) {
      throw new \InvalidArgumentException('Given test method does not exist');
    }

    $this->testCase->setUp();
    $this->testCase->$method();
    $this->testCase->tearDown();
  }
}