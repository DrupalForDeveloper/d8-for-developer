<?php

namespace Drupal\hello;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Produit entity entity.
 *
 * @see \Drupal\hello\Entity\ProduitEntity.
 */
class ProduitEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\hello\Entity\ProduitEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished produit entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published produit entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit produit entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete produit entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add produit entity entities');
  }

}
