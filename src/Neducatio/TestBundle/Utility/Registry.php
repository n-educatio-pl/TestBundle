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

  /**
   * Add value
   *
   * @param string $key   key
   * @param mixed  $value value
   */
  public function add($key, $value)
  {
    if (!array_key_exists($key, $this->store) || !is_array($this->store[$key])) {
      $this->store[$key] = array();
    }
    $this->store[$key][] = $value;
  }
  /**
   * Set or get value.
   *
   * @param string $key   key
   * @param mixed  $value value
   *
   * @return mixed
   */
  public function access($key, $value = null)
  {
    if (func_num_args() === 2) {
      $this->set($key, $value);

      return $value;
    }
    if (array_key_exists($key, $this->store)) {
      return $this->store[$key];
    }
    throw new \RuntimeException("Value under key {$key} not found.");
  }

}