<?php
namespace Acme\AnimalBundle\DataFixtures\ORM;

/**
 * Jerry
 */
class LoadJerryMouseData extends LoadAnimalData
{
  const NAME = __CLASS__;
  protected $order = 1;

  protected $animalData = array(
    'name' => 'Jerry',
    'toy' => null
  );
}