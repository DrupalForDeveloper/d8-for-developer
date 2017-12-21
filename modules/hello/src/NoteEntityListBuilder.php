<?php

namespace Drupal\hello;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Note entity entities.
 *
 * @ingroup hello
 */
class NoteEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Note entity ID2');
    $header['name'] = $this->t('Name');
        $header['id2'] = $this->t('Note entity ID2');
    $header['name2'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\hello\Entity\NoteEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.note_entity.edit_form',
      ['note_entity' => $entity->id()]
    );
    $row['id2'] = $entity->id();
    $row['name2'] = Link::createFromRoute(
      'DELETE ENTITY',
      'entity.note_entity.delete_form',
      ['note_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }


  public function load() {
    
    $entity_query = \Drupal::service('entity.query')->get('produit_entity');
    $header = $this->buildHeader();

    $entity_query->pager(20);
    $entity_query->tableSort($header);

    $uids = $entity_query->execute();

    return $this->storage->loadMultiple($uids);
}

}
