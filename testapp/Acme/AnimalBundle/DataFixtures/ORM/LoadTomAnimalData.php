<?php
namespace Acme\AnimalBundle\DataFixtures\ORM;

/**
 * Tom
 */
class LoadTomAnimalData extends LoadAnimalData
{
  const NAME = __CLASS__;
  protected $order = 2;
  protected $dependentClasses = array(
    LoadJerryAnimalData::NAME,
  );

  protected $animalData = array(
    'name' => 'Tom',
    'toy' => 'animalJerry'
  );
}