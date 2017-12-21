<?php

namespace Drupal\employee\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class DefaultCommand.
 *
 * @DrupalCommand (
 *     extension="employee",
 *     extensionType="module"
 * )
 */
class DefaultCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('employee:default')
      ->setDescription($this->trans('commands.employee.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);
    
   
        
        $query = \Drupal::database()->select('employee', 'e') ; 

        $query->leftJoin('achat', 'a', 'a.employee_id = e.id');
        
        $result =                   $query->fields('a')  
                                    ->condition('e.id', 1, '=')
                                     ->execute()
                                     ->fetchAll() ; 
    
          
                
            print_r($result) ; 
            
            
            /*
      for ($i=0; $i <50 ; $i++) { 
      # code...

      $fields = [
              'name' => 'nadir',
              'email' => 'nad@rou.fr'.$i,
              'department' => 'test '.$i,
              'country' => 'rdes',
              'state' => 'algeria',
              'address' => 'grenoble' ,
              'status' => 1 , 
              'user_id' => 1 
              
    ];

    \Drupal::database()->insert('employee')->fields($fields)->execute();
     $io->info($this->trans('commands.employee.default.messages.success '.$i));

    }
             * 
             */

    $io->info($this->trans('commands.employee.default.messages.success'));
  }

 /**
  * {@inheritdoc}
  */
 protected function interact(InputInterface $input, OutputInterface $output) {
   $io = new DrupalStyle($input, $output);

 }

}







