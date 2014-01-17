<?php

namespace Neducatio\TestBundle\Utility\Awaiter;

/**
 * Description of AwaiterBase
 */
abstract class AwaiterBase
{
    protected $minTime = 500000;
    protected $maxWaitingTime = 4000000;
    protected $waitDistance = 100000;// one tenth of a second

    /**
     * Wait until condition is fulfilled
     *
     * @param Callable $condition        condition callable
     * @param mixed    $result           condition needed result
     * @param string   $exceptionMessage Message will be shown in exception when condition not fulfilled
     *
     * @throws ConditionNotFulfilledException
     */
    public function waitUntil($condition, $result, $exceptionMessage = '')
    {
        $before = microtime(true);
        while ($result !== $condition()) {
          if ((microtime(true) - $before) * 1000000 < $this->maxWaitingTime) {
            usleep($this->waitDistance);
            continue;
          }
          throw new ConditionNotFulfilledException($exceptionMessage);
        }
        usleep($this->minTime);
    }

    /**
     * Wait until true
     *
     * @param Callable $condition        condition callable
     * @param string   $exceptionMessage Message will be shown in exception when condition not fulfilled
     */
    public function waitUntilTrue($condition, $exceptionMessage = '')
    {
      $this->waitUntil($condition, true, $exceptionMessage);
    }

    /**
     * Wait until false
     *
     * @param Callable $condition        condition callable
     * @param string   $exceptionMessage Message will be shown in exception when condition not fulfilled
     */
    public function waitUntilFalse($condition, $exceptionMessage = '')
    {
      $this->waitUntil($condition, false, $exceptionMessage);
    }
}