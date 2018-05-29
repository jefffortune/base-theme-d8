(function (drupal, $) {
  Drupal.behaviors.basic = {
    attach: function (context, settings) {
      // Drupal Behaviors and Jquery here
      // Using jQuery here will help reduce the amount of conflicts between
      // admin interface and global JS functionality.
    }
  }
}(Drupal, jQuery));