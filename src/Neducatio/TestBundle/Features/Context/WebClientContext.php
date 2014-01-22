<?php

namespace Neducatio\TestBundle\Features\Context;

use Neducatio\TestBundle\Utility\WebClientRetriever;

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

    return $this->getRegistry()->access('client', $this->getWebTestClient()->setClient($reference));
  }

  private function getWebTestClient()
  {
    return new WebClientRetriever($this->getContainer());
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
