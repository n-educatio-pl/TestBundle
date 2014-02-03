<?php
namespace Neducatio\TestBundle\DataFixtures;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Neducatio\TestBundle\DataFixtures\FixtureExecutor;
use Neducatio\TestBundle\DataFixtures\ComponentBuilder;
use Neducatio\TestBundle\DataFixtures\UniqueDependencyResolver;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Fixture Dependency Invoker
 */
class FixtureDependencyInvoker
{
  private $em;
  private $executor;
  private $fixtureExecutor;
  private $componentBuilder;
  private $uniqueDependencyResolver;

  /**
   * Constructor
   *
   * @param Kernel $kernel Symfony kernel
   */
  public function __construct(Kernel $kernel = null)
  {
    if ($kernel === null) {
      $kernel = $this->createKernel();
    }
    $container                      = $kernel->getContainer();
    $purger                         = new ORMPurger();

    $this->em                       = $container->get('doctrine')->getManager();
    $this->executor                 = new ORMExecutor($this->em, $purger);
    $this->fixtureExecutor          = new FixtureExecutor($this->executor);
    $this->componentBuilder         = new ComponentBuilder($container);
    $this->uniqueDependencyResolver = new UniqueDependencyResolver();
  }

  /**
   * Gets Fixture Executor
   *
   * @return FixtureExecutor
   */
  public function getFixtureExecutor()
  {
    return $this->fixtureExecutor;
  }

  /**
   * Gets Entity Manager
   *
   * @return EntityManager
   */
  public function getEntityManager()
  {
    return $this->em;
  }

  /**
   * Gets Executor
   *
   * @return ORMExecutor
   */
  public function getExecutor()
  {
    return $this->executor;
  }

  /**
   * Gets Component Builder
   *
   * @return ComponentBuilder
   */
  public function getComponentBuilder()
  {
    return $this->componentBuilder;
  }

  /**
   * Gets Unique Dependency Resolver
   *
   * @return UniqueDependencyResolver
   */
  public function getUniqueDependencyResolver()
  {
    return $this->uniqueDependencyResolver;
  }

  private function createKernel()
  {
    $path = '/../../../../app/AppKernel.php';
    $kernelPath = __DIR__ . (file_exists(__DIR__ . '/../../..' . $path) ? '/../../..' . $path : $path);

    // @codeCoverageIgnoreStart
    require_once $kernelPath;
    // @codeCoverageIgnoreEnd

    $kernel = new \AppKernel("test", true);
    $kernel->boot();

    return $kernel;
  }
}
