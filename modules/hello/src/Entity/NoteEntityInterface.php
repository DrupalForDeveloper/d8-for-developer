<?php

namespace Drupal\hello\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Note entity entities.
 *
 * @ingroup hello
 */
interface NoteEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Note entity name.
   *
   * @return string
   *   Name of the Note entity.
   */
  public function getName();

  /**
   * Sets the Note entity name.
   *
   * @param string $name
   *   The Note entity name.
   *
   * @return \Drupal\hello\Entity\NoteEntityInterface
   *   The called Note entity entity.
   */
  public function setName($name);

  /**
   * Gets the Note entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Note entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Note entity creation timestamp.
   *
   * @param int $timestamp
   *   The Note entity creation timestamp.
   *
   * @return \Drupal\hello\Entity\NoteEntityInterface
   *   The called Note entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Note entity published status indicator.
   *
   * Unpublished Note entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Note entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Note entity.
   *
   * @param bool $published
   *   TRUE to set this Note entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\hello\Entity\NoteEntityInterface
   *   The called Note entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Note entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Note entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\hello\Entity\NoteEntityInterface
   *   The called Note entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Note entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Note entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\hello\Entity\NoteEntityInterface
   *   The called Note entity entity.
   */
  public function setRevisionUserId($uid);

}
