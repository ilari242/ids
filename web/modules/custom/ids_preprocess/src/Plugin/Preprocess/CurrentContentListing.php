<?php

namespace Drupal\ids_preprocess\Plugin\Preprocess;

use Drupal\ids_preprocess\IdsPreProcessPluginBase;

/**
 * Current content listing paragraph preprocessing.
 *
 * @Preprocess(
 *   id = "ids_preprocess.preprocess.paragraph__current_content_listing",
 *   hook = "paragraph__current_content_listing"
 * )
 */
class CurrentContentListing extends IdsPreProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  public function preprocess(array $variables): array {
    $paragraph = $variables['paragraph'];

    return $variables;
  }

}
