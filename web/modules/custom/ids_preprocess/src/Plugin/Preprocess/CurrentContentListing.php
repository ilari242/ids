<?php

namespace Drupal\ids_preprocess\Plugin\Preprocess;

use Drupal\ids_preprocess\IdsPreProcessPluginBase;

/**
 * Current content listing paragraph preprocessing.
 *
 * @Preprocess(
 *   id = "ids_preprocess.preprocess.views_view_unformatted__news__latest_news_block",
 *   hook = "views_view_unformatted__news__latest_news_block"
 * )
 */
class CurrentContentListing extends IdsPreProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  public function preprocess(array $variables): array {
    $liftups = [];

    // Gets nodes in view.
    $view_rows = $variables['rows'];
    $nodes = [];

    foreach ($view_rows as $row) {
      $node = $row['content']['#node'];
      array_push($nodes, $node);
    }

    // Builds liftup objects from nodes.
    foreach($nodes as $node) {
      $liftup_data = [
        'liftup_title' => $node->get('title')->value,
        'liftup_body' => $node->get('field_lead_paragraph')->value,
        'liftup_link_url' => $node->toUrl()->toString(),
      ];

      /** @var \Drupal\Core\Field\EntityReferenceFieldItemList $field_media */
      $field_media = $node->get('field_main_image');
      if ($field_media->isEmpty()) {
        $liftup_data['liftup_img_src'] = '/themes/contrib/emulsify-drupal/images/placeholder.png';
      }
      else {
        $media_entities = $field_media->referencedEntities();
        $media_entity = reset($media_entities);
        $media_render_array = \Drupal::entityTypeManager()->getViewBuilder('media')->view($media_entity, 'liftup');
        $liftup_data['image_field'] = $media_render_array;
      }

      array_push($liftups, $liftup_data);
    }
    $variables['liftups'] = $liftups;

    return $variables;
  }
}
