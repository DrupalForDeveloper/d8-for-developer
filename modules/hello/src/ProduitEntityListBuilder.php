<?php

namespace Drupal\hello;


use Drupal\Core\Link;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;


/**
 * Defines a class to build a listing of Produit entity entities.
 *
 * @ingroup hello
 */
class ProduitEntityListBuilder extends EntityListBuilder {


/**
   * The url generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a new ContactListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Produit entity ID');
    $header['name'] = $this->t('Name');
    $header['price'] = $this->t('Price');
    $header['reference'] = $this->t('Reference');
    $header['view'] = $this->t('View');
    $header['date'] = $this->t('Created');
    $header['poup'] = $this->t('Popup');
    $header['links'] = $this->t('Links');
    $header['operation'] = $this->t('Operation');
    $header['mail'] = $this->t('Mail');
    return $header  ; 
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\hello\Entity\ProduitEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.produit_entity.edit_form',
      ['produit_entity' => $entity->id()]
    );

    $row['price'] = $entity->price->value ; 
    $row['reference'] = $entity->reference->value ;  
    $row['view'] = Link::createFromRoute(
      $entity->label(),
      'hello.product_controller_hello',
      ['produit_entity' => $entity->id()]
    );

    return $row + parent::buildRow($entity);
  }


  public function load() {
    
    $entity_query = \Drupal::service('entity.query')->get('produit_entity');
    $header = $this->buildHeader();
    
    /*
        $this->config('hello.productsettings')
      ->set('pager', $form_state->getValue('pager'))
      ->save();
     * 
     */

    $entity_query->pager(
                \Drupal::getContainer()->get('config.factory')->get('hello.productsettings')->get('pager') ? \Drupal::getContainer()->get('config.factory')->get('hello.productsettings')->get('pager') : 25 
            );
    $entity_query->sort('created' , 'DESC'); 
    

    $uids = $entity_query->execute();

    return $this->storage->loadMultiple($uids);
}


  public function render() {
 


    $build['description2'] = [
      '#markup' => $this->t('Content Entity Example implements a Contacts model. These contacts are fieldable entities. You can manage the fields on the <a href="@adminlink">Contacts admin page</a>.', [
        '@adminlink' => '',
      ]),
    ];

    $rows = [];

    foreach (  $this->load() as $entity ) {
        
        
     $ajax_link_attributes = [
        'attributes' => [
          'class' => 'use-ajax',
          'data-dialog-type' => 'modal',
          'data-dialog-options' => ['width' => 700, 'height' => 400],
        ],
      ];
      
     $ajax_view_url = Url::fromRoute('employee.view',
        ['produit_entity' => $entity->id() ], $ajax_link_attributes);
     
     $mail_url = Url::fromRoute('entity.produit_entity.collection',  ['produit_entity' => $entity->id()] , $ajax_link_attributes);
        
    $url = Url::fromRoute('entity.produit_entity.collection', ['produit_entity' => $entity->id()] );
    $url2 = Url::fromRoute('entity.produit_entity.collection', ['produit_entity' => $entity->id()] );
    $url3 = Url::fromRoute('entity.produit_entity.collection', ['produit_entity' => $entity->id()] );
    
    $link_options = array(
    'attributes' => [
            'class' => ['use-ajax'],
            'data-dialog-type' => 'modal',
            'data-dialog-options' => json_encode([
              'width' => 900,
            ])
          ],
    );
    $url->setOptions($link_options);
    $link = Link::fromTextAndUrl(t('View Entity'), $url)->toString();

    $drop_button = [
        '#type' => 'dropbutton',
        '#links' => [
          'view' => [
            'title' => t('View'),
            'url' =>  $url->setOptions($link_options) ,
          ],
          'edit' => [
            'title' => t('Edit'),
            'url' => $url2->setOptions($link_options) ,
          ],
          'mail' => [
            'title' => t('Mail'),
            'url' =>  $url3->setOptions($link_options) ,
          ],
        ],
      ];
    

          $rows[] = array(
            $entity->id->value ,       
            $entity->name->value , 
            $entity->price->value , 
            $entity->reference->value , 
            Link::createFromRoute(
                  $entity->label(),
                  'hello.product_controller_hello',
                  ['produit_entity' => $entity->id()]
                ) , 
            $entity->created->value , 
            Link::fromTextAndUrl("help", Url::fromRoute('hello.product_controller_hello',['produit_entity' => $entity->id() , $ajax_link_attributes  ] )  ), 
            Link::fromTextAndUrl(t('View Entity'), $url)->toString()
              , 
               'actions' => [
                    'data' => $drop_button
                ],
              
           $entity->mail->value 
            ) ; 

    }

    $build['table'] = [
      '#type' => 'table',
      '#header' => $this->buildHeader(),
      '#title' => $this->getTitle(),
      '#rows' => $rows ,
            '#attributes' => [
            'class' => ['product_viewer'],
                      ],
      '#empty' => $this->t('There is no @label yet.', ['@label' => $this->entityType->getLabel()]),
      '#cache' => [
        'contexts' => $this->entityType->getListCacheContexts(),
        'tags' => $this->entityType->getListCacheTags(),
      ],
    ];


    if ($this->limit) {
      $build['pager'] = [
        '#type' => 'pager',
      ];
    }


    $build['table']['#attached']['library'][] = 'core/drupal.dialog.ajax';


    return $build;
  }


  
}
