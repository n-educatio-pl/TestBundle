<?php

namespace Acme\AnimalBundle\Entity;

/**
 * Animal class
 */
class Animal
{
  private $name;
  private $toy;
  private $live = true;

  /**
   * Constructor
   *
   * @param string $name Name
   */
  public function __construct($name)
  {
    $this->name = $name;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set toy
   *
   * @param Animal $toy animal's toy
   */
  public function setToy(Animal $toy)
  {
    $this->toy = $toy;
  }

  /**
   * Get toy
   *
   * @return Animal || null
   */
  public function getToy()
  {
    return $this->toy;
  }

  /**
   * Eat toy
   */
  public function eatToy()
  {
    if ($this->toy === null) {
      $this->live = false;
    } else {
      $this->toy->eatToy();
    }
  }

  /**
   * Is alive
   *
   * @return boolean
   */
  public function isAlive()
  {
    return $this->live;
  }
}
