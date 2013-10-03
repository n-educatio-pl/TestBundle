<?php

namespace Neducatio\TestBundle\Utility;

/**
 * Description of Awaiter
 */
class Awaiter
{
    protected $minTime = 500000;
    protected $maxWaitingTime = 4000000;
    protected $waitDistance = 100000;// one tenth of a second

    /**
     * Wait until condition is fulfilled
     *
     * @param Callable $condition condition callable
     * @param mixed    $result    condition needed result
     *
     * @throws ConditionNotFulfilledException
     */
    public function waitUntil($condition, $result)
    {
        $before = microtime(true);
        while ($result !== $condition()) {
          if ((microtime(true) - $before) * 1000000 < $this->maxWaitingTime) {
            usleep($this->waitDistance);
            continue;
          }
          throw new ConditionNotFulfilledException();
        }
        usleep($this->minTime);
    }
}