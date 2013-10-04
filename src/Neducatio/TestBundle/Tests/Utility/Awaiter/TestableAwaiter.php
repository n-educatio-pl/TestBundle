<?php
namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\Awaiter;

/**
 * Description of TestableAwaiter
 * 
 * Lower times speed up tests
 */
class TestableAwaiter extends Awaiter
{
    public $minTime = 5000;
    public $maxWaitingTime = 10000;
    public $waitDistance = 1000;
    public $page;
}
