<?php

namespace Neducatio\TestBundle\Tests\Utility\PHPUnit;

use Neducatio\TestBundle\Utility\PHPUnit\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Sample test for PHPUnitRunner tests
 */
class SampleWebTestCase extends WebTestCase
{
  static private $hasKernelClass = false;

  /**
   * Construct
   *
   * @param type  $name     Name
   * @param array $data     Data
   * @param type  $dataName DataName
   */
  public function __construct($name = null, array $data = array(), $dataName = '')
  {
    static::$hasKernelClass = false;
    parent::__construct($name, $data, $dataName);
  }

  /**
   * @test
   */
  public function checkIfTrueEqualsTrue()
  {
    static::createClient();
    $this->assertTrue(true);
  }

  /**
   * Set kernel class
   *
   * @param KernelInterface $kernel App kernel
   */
  static public function setKernelClass(KernelInterface $kernel)
  {
    static::$hasKernelClass = true;
    parent::setKernelClass($kernel);
  }

  /**
   * Check if kernel class is defined
   *
   * @return boolean
   */
  public function hasKernelClass()
  {
    return static::$hasKernelClass;
  }
}

