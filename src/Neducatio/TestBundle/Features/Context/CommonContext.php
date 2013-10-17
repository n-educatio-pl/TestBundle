<?php
namespace Neducatio\TestBundle\Features\Context;

/**
 * Common features
 */
class CommonContext extends BaseSubContext
{
    /**
     * Do sth.
     *
     * @Given /^system ready to be tested$/
     */
    public function systemReadyToBeTested()
    {
        $this->loadFixtures();
    }
}