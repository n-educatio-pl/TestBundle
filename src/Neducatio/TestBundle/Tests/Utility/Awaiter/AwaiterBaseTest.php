<?php

namespace Neducatio\TestBundle\Tests\Utility\Awaiter;

use Neducatio\TestBundle\Tests\Utility\Awaiter\TestableAwaiterBase;
use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\Awaiter\AwaiterBase
 */
class AwaiterBaseTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Tests constructor
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('Neducatio\TestBundle\Utility\Awaiter\AwaiterBase', $this->getAwaiter());
  }

  /**
   * Tests waitUntil
   *
   * @test
   * @return null
   */
  public function waitUntil_conditionIsAleradyFulfilled_waitMinimumTimeAndReturnSelf()
  {
    $awaiter = $this->getAwaiter();
    $this->startTimer();
    $awaiter->waitUntil(function() {
        return true;
    }, true);
    $this->stopTimer();
    $this->assertWaitMoreThanOrEqualMicroseconds($awaiter->minTime);
  }

  /**
   * Tests waitUntil
   *
   * @test
   */
  public function waitUntil_conditionIsFulfilledTwoTimesEarlierThanMaxWaitingTime_waitMoreThanHalfOfMaxWaitingTimePlusMinimumTimeAndLessThanMaxWaitingTimePlusMinimumTime()
  {
    $awaiter = $this->getAwaiter();
    $this->startTimer();
    $condition = $this->getCondition($awaiter, 0.5, false, true);
    $awaiter->waitUntil($condition, true);
    $this->stopTimer();
    $this->assertWaitMoreThanOrEqualMicroseconds($awaiter->maxWaitingTime * 0.5 + $awaiter->minTime);
    $this->assertWaitLessThanOrEqualMicroseconds($awaiter->maxWaitingTime + $awaiter->minTime);
  }

  /**
   * Tests waitUntil
   *
   * @test
   * @expectedException \Neducatio\TestBundle\Utility\Awaiter\ConditionNotFulfilledException
   */
  public function waitUntil_conditionIsFulfilledAfterMaxWaitingTime_waitMoreThanOrEqualMaxWaitingTimeAndThrowContitionNotFulfilledException()
  {
    $awaiter = $this->getAwaiter();
    $this->startTimer();
    $condition = $this->getCondition($awaiter, 2, false, true);
    $awaiter->waitUntil($condition, true);
    $this->stopTimer();
    $this->assertWaitMoreThanOrEqualMicroseconds($awaiter->maxWaitingTime);
  }

  /**
   * Tests waitUntilTrue
   *
   * @test
   */
  public function waitUntilTrue_conditionIsFulfilledTwoTimesEarlierThanMaxWaitingTime_waitMoreThanHalfOfMaxWaitingTimePlusMinimumTimeAndLessThanMaxWaitingTimePlusMinimumTime()
  {
    $awaiter = $this->getAwaiter();
    $this->startTimer();
    $condition = $this->getCondition($awaiter, 0.5, false, true);
    $awaiter->waitUntilTrue($condition);
    $this->stopTimer();
    $this->assertWaitMoreThanOrEqualMicroseconds($awaiter->maxWaitingTime * 0.5 + $awaiter->minTime);
    $this->assertWaitLessThanOrEqualMicroseconds($awaiter->maxWaitingTime + $awaiter->minTime);
  }

  /**
   * Tests waitUntilFalse
   *
   * @test
   */
  public function waitUntilFalse_conditionIsFulfilledTwoTimesEarlierThanMaxWaitingTime_waitMoreThanHalfOfMaxWaitingTimePlusMinimumTimeAndLessThanMaxWaitingTimePlusMinimumTime()
  {
    $awaiter = $this->getAwaiter();
    $this->startTimer();
    $condition = $this->getCondition($awaiter, 0.5, true, false);
    $awaiter->waitUntilFalse($condition);
    $this->stopTimer();
    $this->assertWaitMoreThanOrEqualMicroseconds($awaiter->maxWaitingTime * 0.5 + $awaiter->minTime);
    $this->assertWaitLessThanOrEqualMicroseconds($awaiter->maxWaitingTime + $awaiter->minTime);
  }

  private function getCondition($awaiter, $partOfTime, $resultBefore, $resultAfter)
  {
    $startTime = microtime(true);
    $neededTime = intval($partOfTime * $awaiter->maxWaitingTime);
    $condition = function() use ($startTime,
            $neededTime, $resultBefore, $resultAfter) {
        $diffTime = intval((microtime(true) - $startTime) * 1000000);
        if ($diffTime >= $neededTime) {
            return $resultAfter;
        }

        return $resultBefore;
    };

    return $condition;
  }

  private function startTimer()
  {
      $this->startTime = microtime(true);
  }

  private function stopTimer()
  {
      $this->stopTime = microtime(true);
  }

  private function assertWaitMoreThanOrEqualMicroseconds($microseconds)
  {
      $this->assertGreaterThanOrEqual($microseconds, ($this->stopTime - $this->startTime) * 1000000);
  }

  private function assertWaitLessThanOrEqualMicroseconds($microseconds)
  {
      $this->assertLessThanOrEqual($microseconds, ($this->stopTime - $this->startTime) * 1000000);
  }

  /**
   * Create and return new Awaiter object
   *
   * @return Awaiter
   */
  private function getAwaiter()
  {
    return new TestableAwaiterBase();
  }
}