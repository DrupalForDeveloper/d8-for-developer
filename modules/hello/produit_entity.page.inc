<?php


function template_preprocess_produit_entity(array &$variables) {
  // Fetch ProduitEntity Entity Object.
  $produit_entity = $variables['elements']['#produit_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
