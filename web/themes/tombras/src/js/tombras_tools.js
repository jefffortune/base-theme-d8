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

window.addEventListener('load', () => {
  const TRIGGER = document.getElementById('tool-trigger');
  const TOOL_CONTAINER = document.getElementById('tombras-tools');
  const BODY = document.getElementsByTagName("BODY")[0];
  
  if(TRIGGER !== null) {
    TRIGGER.addEventListener('click', () => {
      BODY.classList.toggle('open--tool-menu');
      TRIGGER.classList.toggle('change');
      if(typeof TOOL_CONTAINER !== 'undefined') {
        TOOL_CONTAINER.classList.toggle('active--tool-menu');
      }
    })
  }
});
