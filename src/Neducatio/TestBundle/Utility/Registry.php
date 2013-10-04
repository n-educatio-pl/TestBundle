<?php

namespace Neducatio\TestBundle\Utility;


/**
 * Description of Registry
 */
class Registry
{
  private $store = array();

  /**
   * Store some value
   *
   * @param string $key   key
   * @param mixed  $value value
   */
  public function set($key, $value)
  {
    $this->store[$key] = $value;
  }

  /**
   * Get stored value
   *
   * @param string $key          key
   * @param mixed  $defaultValue default value
   *
   * @return mixed
   */
  public function get($key, $defaultValue = null)
  {
    if (array_key_exists($key, $this->store)) {

      return $this->store[$key];
    }

    return $defaultValue;
  }

}