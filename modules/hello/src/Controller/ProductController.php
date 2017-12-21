<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManager;

/**
 * Class ProductController.
 */
class ProductController extends ControllerBase {


    /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;

  /**
   * Constructs a new DefaultController object.
   */
  public function __construct(EntityManager $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')
    );
  }


  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function getEntityProductById($produit_entity) {


    $fids = \Drupal::entityQuery('produit_entity')
            ->condition('id', $produit_entity , '=')
            ->execute();


    $entitytype_manager = \Drupal::service('entity_type.manager');
    $storage = $entitytype_manager->getStorage('produit_entity');
    $files = $storage->loadMultiple($fids);


    $header = [
      // The header gives the table the information it needs in order to make
      // the query calls for ordering. TableSort uses the field information
      // to know what database column to sort by.
      ['data' => t('id'), 'Name' ],
      ['data' => t('Price'), 'Name' ],
      ['data' => t('Name'), 'Name' ],
    ];


    $row[] = array(
            $files[$produit_entity]->id->value ,       
            $files[$produit_entity]->name->value , 
            $files[$produit_entity]->price->value 
      ) ; 

    $build['view_product']['#markup'] = $this->t("<h1>Produit id @id</h1> Ref. Owner @ow <hr/>" ,
                         ['@id' => $produit_entity  , '@ow' => $files[$produit_entity]->name->value ]  ) ; 

    $build['view_product']['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $row,
      '#attributes' => [
            'class' => ['product_viewer'],
                      ],
    ];

    return $build;

  }

}

