<?php

namespace Drupal\hello\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class DebugCommand.
 *
 * @DrupalCommand (
 *     extension="hello",
 *     extensionType="module"
 * )
 */
class DebugCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('debug')
      ->setDescription($this->trans('commands.debug.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $id = 903 ; 

    $fids = \Drupal::entityQuery('produit_entity')
            ->condition('id', $id , '=')
            ->execute();


    $entitytype_manager = \Drupal::service('entity_type.manager');
    $storage = $entitytype_manager->getStorage('produit_entity');
    $files = $storage->loadMultiple($fids);

        
    
  }

 /**
  * {@inheritdoc}
  */
 protected function interact(InputInterface $input, OutputInterface $output) {
   $io = new DrupalStyle($input, $output);

 }

}
