<?php

namespace Neducatio\TestBundle\Utility\PHPUnit;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

/**
 * PHPUnit test runner
 */
class WebTestCase extends BaseWebTestCase
{
    /**
     * Set kernel class for web test case
     *
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel App kernel
     */
    static public function setKernelClass(KernelInterface $kernel)
    {
        static::$class = get_class($kernel);
    }
}
