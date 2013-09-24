<?php

namespace Neducatio\TestBundle\DataFixtures;

/**
 * Component of Composite Design Pattern that contains Fixture.
 *
 * It can be traversed easily.
 */
class FixtureComponent implements FixtureComponentInterface
{
  private $id = null;
  private $fixture;
  private $children = array();
  /**
   * Embrace original fixture.
   *
   * @param LoadableInterface $fixture Fixture with dependent subfixture classes
   */
  public function __construct(LoadableInterface $fixture)
  {
    $this->fixture = $fixture;
  }
  /**
   * Do sth.
   *
   * @param DependencyComponentInterface $subcomponent Child component
   */
  public function add(DependencyComponentInterface $subcomponent)
  {
    $this->children[] = $subcomponent;
  }
  /**
   * Do sth.
   *
   * @return integer Id
   * @throws \RuntimeException
   */
  public function getId()
  {
    if (null === $this->id) {
      throw new \RuntimeException("Id must be set");
    }

    return $this->id;
  }
  /**
   * Do sth.
   *
   * @param string $id Id of Component
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * Do sth.
   *
   * @param array $children Children
   */
  public function setChildren(array $children)
  {
    $this->children = $children;
  }
  /**
   * Do sth.
   *
   * @return array Children
   */
  public function getChildren()
  {
    return $this->children;
  }
  /**
   * Do sth.
   *
   * @return LoadableInterface Fixture
   */
  public function getFixture()
  {
    return $this->fixture;
  }
}
