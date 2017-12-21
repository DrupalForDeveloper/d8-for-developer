<?php

namespace Drupal\hello;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\hello\Entity\NoteEntityInterface;

/**
 * Defines the storage handler class for Note entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Note entity entities.
 *
 * @ingroup hello
 */
interface NoteEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Note entity revision IDs for a specific Note entity.
   *
   * @param \Drupal\hello\Entity\NoteEntityInterface $entity
   *   The Note entity entity.
   *
   * @return int[]
   *   Note entity revision IDs (in ascending order).
   */
  public function revisionIds(NoteEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Note entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Note entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\hello\Entity\NoteEntityInterface $entity
   *   The Note entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(NoteEntityInterface $entity);

  /**
   * Unsets the language for all Note entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
