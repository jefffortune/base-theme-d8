DESCRIPTION
-----------
Allow editors to select a responsive image style on an inline embedded entity of type media image.


INSTALL
-----------
Media with Entity Embed Responsive Images
- composer update to patch entity_embed
- en inline_responsive_entity
- update basic_html text filter
  - enable 'Set responsive style on images' and make this the first filter
  - make sure in the "Allowed html tags" you see data-responsive-style inside the <drupal-entity> tag
