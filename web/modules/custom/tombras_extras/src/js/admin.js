(function (drupal, $) {
  Drupal.behaviors.basic = {
    attach: function (context, settings) {
      // Drupal Behaviors and Jquery here
      // Using jQuery here will help reduce the amount of conflicts between
      // admin interface and global JS functionality.
      var color_select = $('.field--name-field-background-color input, .field--name-field-font-color input');
      if(color_select.length > 0) {
        for (var i = 0; i < color_select.length; i++) {
          if (color_select[i].value !== '_none') {
            var label = color_select[i].labels[0];
            label.innerHTML = `<span style="border: 1px solid black; background-color: #${color_select[i].value}; width: 40px; height: 20px; display: inline-block"></span>`
          }
        }
      }
    }
  }
}(Drupal, jQuery));