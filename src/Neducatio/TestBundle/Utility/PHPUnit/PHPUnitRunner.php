<?php

namespace Neducatio\TestBundle\Utility\PHPUnit;

use Symfony\Component\HttpKernel\KernelInterface;
use Neducatio\TestBundle\Utility\PHPUnit\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

/**
 * PHPUnit test runner
 */
class PHPUnitRunner
{
  private $testCase;

  /**
   * Prepare test case object
   *
   * @param string          $testClassNamespace Test class namespace
   * @param KernelInterface $kernel             Kernel
   *
   * @throws \InvalidArgumentException
   */
  public function __construct($testClassNamespace, KernelInterface $kernel = null)
  {
    if (!class_exists($testClassNamespace)) {
      throw new \InvalidArgumentException('Given test class does not exist');
    }

    $this->testCase = new $testClassNamespace;

    if (!($this->testCase instanceof \PHPUnit_Framework_TestCase)) {
      throw new \InvalidArgumentException('Given test class does not extend \PHPUnit_Framework_TestCase');
    }

    if ($this->testCase instanceof WebTestCase) {
      $this->setTestCaseKernel($testClassNamespace, $kernel);
    } else if ($this->testCase instanceof BaseWebTestCase) {
      throw new \InvalidArgumentException('Given web test case does not extend \Neducatio\TestBundle\Utility\PHPUnit\WebTestCase');
    }

    $testClassNamespace::setUpBeforeClass();
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

    $setUpReflection = new \ReflectionMethod($this->testCase, 'setUp');
    $tearDownReflection = new \ReflectionMethod($this->testCase, 'tearDown');

    if ($setUpReflection->isPublic()) {
        $this->testCase->setUp();
    }

    $this->testCase->$method();

    if ($tearDownReflection->isPublic()) {
        $this->testCase->tearDown();
    }
  }

  /**
   * Call tear down after class on test case
   */
  public function tearDownAfterClass()
  {
    $class = $this->testCase;
    $class::tearDownAfterClass();
  }

  private function setTestCaseKernel($testClassNamespace, KernelInterface $kernel = null)
  {
    if ($kernel === null) {
      throw new \InvalidArgumentException('Kernel object is not defined');
    }

    $testClassNamespace::setKernelClass($kernel);
  }
}