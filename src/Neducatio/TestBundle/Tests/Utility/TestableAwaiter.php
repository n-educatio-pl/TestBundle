<?php
namespace Neducatio\TestBundle\Tests\Utility;

use Neducatio\TestBundle\Utility\Awaiter;

/**
 * Description of TestableAwaiter
 */
class TestableAwaiter extends Awaiter
{
    public $minTime = 5000;
    public $maxWaitingTime = 10000;
    public $waitDistance = 1000;
}
