<?php
namespace Acme\AnimalBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Neducatio\TestBundle\DataFixtures\Fixture;
use Acme\AnimalBundle\Entity\Animal;

/**
* Loads fixtures
*/
abstract class LoadAnimalData extends Fixture implements OrderedFixtureInterface
{
  protected $prefix = 'animal';
  protected $order;
  protected $animalData = array();

 /**
   * Zapisuje dane w bazie uzywajac $this->data. Load data fixtures with the passed EntityManager.
   *
   * @param Doctrine\Common\Persistence\ObjectManager $manager Manager
   */
  public function load(ObjectManager $manager)
  {
    $manager;
    $animal = new Animal($this->animalData['name']);
    if ($this->animalData['toy'] !== null) {
      $animal->setToy($this->getReference($this->animalData['toy']));
    }
    $this->addReference($this->prefix . $this->animalData['name'], $animal);
  }

  /**
   * Definiuje jako ktory fixture ma się wykonac
   *
   * @return int
   */
  public function getOrder()
  {
    return $this->order;
  }
}