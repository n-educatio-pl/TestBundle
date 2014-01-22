<?php

namespace Neducatio\TestBundle\Utility;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Client;
use FOS\UserBundle\Entity\User;

/**
 * TestClientRetriever
 */
class WebClientRetriever
{
  private $container;

  /**
   * Constructor
   *
   * @param Container $em
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  /**
   * Gets logged in browser client
   *
   * @param User $reference User reference
   *
   * @return Client
   */
  public function setClient($reference)
  {
    return $this->logInUser($reference);
  }

  private function logInUser($reference)
  {
    $client  = $this->container->get('test.client');
    $crawler = $client->request('GET', '/login');
    $form    = $crawler->selectButton('_submit')->form();

    $client->submit($form, array('_username' => $reference->getUsername(), '_password' => 'test'));

    return $client;
  }
}
