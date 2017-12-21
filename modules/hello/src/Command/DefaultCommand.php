<?php

namespace Drupal\hello\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class DefaultCommand.
 *
 * @DrupalCommand (
 *     extension="hello",
 *     extensionType="module"
 * )
 */
class DefaultCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('hello:default')
      ->setDescription($this->trans('commands.hello.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);


for ($i=0; $i < 500 ; $i++) { 
  # code...
     $data = array(
      'name' => $this->makeRandomString() , 
      'price' => rand(100,1000)." €" , 
      'reference' => $this->makeRandomString() , 
      'mail' => 'nadir@fouka.ovh'
    );


    $node = \Drupal::entityManager()
                    ->getStorage('produit_entity')
                    ->create($data);
    $node->save();
    $io->info($this->trans('commands.content_entity_example.default.messages.success '.$i));
}


print_r( \Drupal::getContainer()->get('config.factory')->get('hello.productsettings')->get('pager') ) ; 

  }

 /**
  * {@inheritdoc}
  */
 protected function interact(InputInterface $input, OutputInterface $output) {
   $io = new DrupalStyle($input, $output);

 }

  public function makeRandomString($max=24) {
    $i = 0; //Reset the counter.
    $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $keys_length = strlen($possible_keys);
    $str = ""; //Let's declare the string, to add later.
    while($i<$max) {
        $rand = mt_rand(1,$keys_length-1);
        $str.= $possible_keys[$rand];
        $i++;
    }
    return $str;
}

}
