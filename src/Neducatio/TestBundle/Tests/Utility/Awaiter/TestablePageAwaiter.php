<?php
namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Utility\Awaiter\PageAwaiter;

/**
 * Description of TestableAwaiter
 * 
 * Lower times speed up tests
 */
class TestablePageAwaiter extends PageAwaiter
{
    public $minTime = 5000;
    public $maxWaitingTime = 10000;
    public $waitDistance = 1000;
    public $page;
}
