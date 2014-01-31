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
   * @param User    $reference       User reference
   * @param boolean $followRedirects Flag that makes client do redirects automatically
   *
   * @return Client
   */
  public function setClient($reference, $followRedirects)
  {
    return $this->logInUser($reference, $followRedirects);
  }

  private function logInUser($reference, $followRedirects)
  {
    $client  = $this->container->get('test.client');
    if ($followRedirects) {
      $client->followRedirects();
    }
    $parameters = $this->getLoginFormParameters();
    $crawler = $client->request('GET', $parameters['form_url']);
    $form    = $crawler->selectButton($parameters['submit_button_name'])->form();

    $client->submit($form, array($parameters['username_field_name'] => $reference->getUsername(), $parameters['password_field_name'] => 'test'));

    return $client;
  }

  private function getLoginFormParameters()
  {
    if (!$this->container->hasParameter('neducatio_test.web_client_login_form_params')) {

      throw new LoginFormParameterNotFoundException('Login form parameters not defined!');
    }
    $parameters = $this->container->getParameter('neducatio_test.web_client_login_form_params');
    $paramNames = array('form_url', 'username_field_name', 'password_field_name', 'submit_button_name');
    foreach ($paramNames as $paramName) {
      if (!isset($parameters[$paramName])) {

        throw new LoginFormParameterNotFoundException('Login form parameter: "'.$paramName.'" not defined!');
      }
    }

    return $parameters;
  }
}
