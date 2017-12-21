<?php

/**
 * @file
 * Contains note_entity.page.inc.
 *
 * Page callback for Note entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Note entity templates.
 *
 * Default template: note_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */


 
function template_preprocess_note_entity(array &$variables) {
  // Fetch NoteEntity Entity Object.
  $note_entity = $variables['elements']['#note_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}


