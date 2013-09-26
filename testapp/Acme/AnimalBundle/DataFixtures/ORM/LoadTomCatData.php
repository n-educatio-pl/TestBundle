<?php
namespace Acme\AnimalBundle\DataFixtures\ORM;

/**
 * Tom
 */
class LoadTomCatData extends LoadAnimalData
{
  const NAME = __CLASS__;
  protected $order = 2;
  protected $dependentClasses = array(
    LoadJerryMouseData::NAME,
  );

  protected $animalData = array(
    'name' => 'Tom',
    'toy' => 'animalJerry'
  );
}