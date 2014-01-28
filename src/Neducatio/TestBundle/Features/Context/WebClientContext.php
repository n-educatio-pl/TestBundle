<?php

namespace Neducatio\TestBundle\Features\Context;

/**
 * Web Client Context
 */
class WebClientContext extends BaseSubContext
{
  protected function client($reference = null)
  {
    if ($reference === null) {

      return $this->getRegistry()->get('client');
    }

    return $this->getRegistry()->access('client', $this->getContainer()->get('neducatio_test.web_client')->setClient($reference));
  }

  protected function getEntityManager()
  {
    return $this->getContainer()->get('doctrine')->getManager();
  }

  protected function getContainer()
  {
    return $this->kernel->getContainer();
  }
}
