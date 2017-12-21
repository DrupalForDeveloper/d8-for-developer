<?php

namespace Drupal\hello;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Note entity entity.
 *
 * @see \Drupal\hello\Entity\NoteEntity.
 */
class NoteEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\hello\Entity\NoteEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished note entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published note entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit note entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete note entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add note entity entities');
  }

}
