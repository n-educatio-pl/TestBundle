<?php
namespace Neducatio\TestBundle\Tests\DataFixtures\FakeFixture;

use Neducatio\TestBundle\DataFixtures\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Do sth.
 *
 */
class P extends Fixture
{
  const NAME = __CLASS__;
  protected $dependentClasses = array(
      X::NAME,
      Y::NAME,
  );

  /**
   * Loads
   *
   * @param ObjectManager $manager Manager
   */
  public function load(ObjectManager $manager)
  {
    $manager;
  }
}