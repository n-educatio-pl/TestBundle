<?php

namespace Neducatio\TestBundle\Features\Context;

/**
 * Web Client Context
 */
class WebClientContext extends BaseSubContext
{
  protected $client;

  protected function client($reference = null, $followRedirects = true)
  {
    if ($reference === null) {
      $this->client = $this->getRegistry()->get('client');
    } else {
      $this->client = $this->getRegistry()->access('client', $this->getContainer()->get('neducatio_test.web_client')->setClient($reference, $followRedirects));
    }

    return $this->client;
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
