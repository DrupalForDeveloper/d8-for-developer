<?php

namespace Drupal\hello\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Produit entity entities.
 *
 * @ingroup hello
 */
interface ProduitEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Produit entity name.
   *
   * @return string
   *   Name of the Produit entity.
   */
  public function getName();

  /**
   * Sets the Produit entity name.
   *
   * @param string $name
   *   The Produit entity name.
   *
   * @return \Drupal\hello\Entity\ProduitEntityInterface
   *   The called Produit entity entity.
   */
  public function setName($name);

  /**
   * Gets the Produit entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Produit entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Produit entity creation timestamp.
   *
   * @param int $timestamp
   *   The Produit entity creation timestamp.
   *
   * @return \Drupal\hello\Entity\ProduitEntityInterface
   *   The called Produit entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Produit entity published status indicator.
   *
   * Unpublished Produit entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Produit entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Produit entity.
   *
   * @param bool $published
   *   TRUE to set this Produit entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\hello\Entity\ProduitEntityInterface
   *   The called Produit entity entity.
   */
  public function setPublished($published);

}
