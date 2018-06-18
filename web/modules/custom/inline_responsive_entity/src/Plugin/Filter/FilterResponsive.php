<?php

namespace Drupal\inline_responsive_entity\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a filter to choose responsive style on elements.
 *
 * @Filter(
 *   id = "filter_responsive",
 *   title = @Translation("Set responsive style on images"),
 *   description = @Translation("Uses a <code>data-responsive-style</code> attribute on <code>&lt;img&gt;</code> tags to set style on images."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class FilterResponsive extends FilterBase {

  // Copied from FilterResponsiveImageStyl.php in inline_responsive_images module.

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    if (stristr($text, 'data-responsive-style') !== FALSE) {
      $image_styles = \Drupal::entityTypeManager()->getStorage('responsive_image_style')->loadMultiple();

      $dom = Html::load($text);
      $xpath = new \DOMXPath($dom);
      foreach ($xpath->query('//*[@data-entity-uuid and @data-responsive-style]') as $node) { //@data-entity-type="media" and
        $file_uuid = $node->getAttribute('data-entity-uuid');
        $image_style_id = $node->getAttribute('data-responsive-style');

        // If the image style is not a valid one, then don't transform the HTML.
        if (empty($file_uuid) || !isset($image_styles[$image_style_id])) {
          continue;
        }

        // Retrieved matching file in array for the specified uuid.
        $matching_files = \Drupal::entityTypeManager()->getStorage('media')->loadByProperties(['uuid' => $file_uuid]); // was entity_type=file
        $media_entity = reset($matching_files);

        // Stop further element processing, if it's not a valid file.
        if (!$media_entity) {
          continue;
        }

        $uri = $media_entity->field_media_image->entity->getFileUri();
        $image = \Drupal::service('image.factory')->get($uri);

        // Stop further element processing, if it's not a valid image.
        if (!$image->isValid()) {
          continue;
        }

        $width = $image->getWidth();
        $height = $image->getHeight();

        $node->removeAttribute('width');
        $node->removeAttribute('height');
        $node->removeAttribute('src');

        // Make sure all non-regenerated attributes are retained.
        $attributes = array();
        for ($i = 0; $i < $node->attributes->length; $i++) {
          $attr = $node->attributes->item($i);
          $attributes[$attr->name] = $attr->value;
        }

        // Set up image render array.
        $image = array(
          '#theme' => 'responsive_image',
          '#uri' => $uri, //$file->getFileUri(),
          '#width' => $width,
          '#height' => $height,
          '#attributes' => $attributes,
          '#responsive_image_style_id' => $image_style_id,
        );

        $altered_html = \Drupal::service('renderer')->render($image);

        // Load the altered HTML into a new DOMDocument and retrieve the elements.
        $alt_nodes = Html::load(trim($altered_html))->getElementsByTagName('body')
          ->item(0)
          ->childNodes;

        foreach ($alt_nodes as $alt_node) {
          // Import the updated node from the new DOMDocument into the original
          // one, importing also the child nodes of the updated node.
          $new_node = $dom->importNode($alt_node, TRUE);
          // Add the image node(s)!
          // The order of the children is reversed later on, so insert them in reversed order now.
          $node->parentNode->insertBefore($new_node, $node);
        }
        // Finally, remove the original image node.
        $node->parentNode->removeChild($node);
      }

      return new FilterProcessResult(Html::serialize($dom));
    }

    return new FilterProcessResult($text);
  }



  /**
   * {@inheritdoc}
   *
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);

    if (stristr($text, 'data-responsive-style') !== FALSE) {
      $dom = Html::load($text);
      $xpath = new \DOMXPath($dom);
      foreach ($xpath->query('//*[@data-responsive-style]') as $node) {
        // Read the data-align attribute's value, then delete it.
        $style = $node->getAttribute('data-responsive-style');
        $node->removeAttribute('data-responsive-style');

        // @todo get style name, get responsive settings and return formatted picture tag.

        $node->setAttribute('responsive-style', $style);


        // If one of the allowed alignments, add the corresponding class.
//        if (in_array($align, ['left', 'center', 'right'])) {
//          $classes = $node->getAttribute('class');
//          $classes = (strlen($classes) > 0) ? explode(' ', $classes) : [];
//          $classes[] = 'align-' . $align;
//          $node->setAttribute('class', implode(' ', $classes));
//        }
      }
      $result->setProcessedText(Html::serialize($dom));
    }

    return $result;
  }
   */

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
      return $this->t('<p>Set the responsive style of the image.</p>');
  }

}
