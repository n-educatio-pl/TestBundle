<?php
namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\AwaiterBase;

/**
 * Description of TestableAwaiterBase
 */
class TestableAwaiterBase extends AwaiterBase
{
    public $minTime = 5000;
    public $maxWaitingTime = 10000;
    public $waitDistance = 1000;
}
