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
  private $client;

  /**
   * Constructor
   *
   * @param Container $container
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
    $this->client = $container->get('test.client');
  }

  /**
   * Gets logged in browser client
   *
   * @param User    $reference       User reference
   * @param boolean $followRedirects Flag that makes client do redirects automatically
   *
   * @return Client
   */
  public function getClient($reference, $followRedirects = true)
  {
    if ($followRedirects) {
      $this->client->followRedirects();
    }
    if ($reference === '') {

      return $this->client;
    }

    return $this->logInUser($reference);
  }

  private function logInUser($reference)
  {
    $parameters = $this->getLoginFormParameters();
    $crawler = $this->client->request('GET', $parameters['form_url']);
    $form    = $crawler->selectButton($parameters['submit_button_name'])->form();

    $this->client->submit($form, array($parameters['username_field_name'] => $reference->getUsername(), $parameters['password_field_name'] => 'test'));

    return $this->client;
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
