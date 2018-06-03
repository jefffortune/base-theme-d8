(function (Drupal, $) {
  // Drupal Behaviors and Jquery here
  // Using jQuery here will help reduce the amount of conflicts between
  // admin interface and global JS functionality.
  Drupal.behaviors.tombras = {
    attach: function (context, settings) {
      //Can access all the drupal behaviors from here
    }
  }
}(Drupal, jQuery));