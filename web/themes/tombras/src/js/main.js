(function (Drupal, $) {
  
  const MOBILE_BUTTON = document.getElementById('mobile-button');
  const MAIN_MENU = document.getElementById('main-menu');


  MOBILE_BUTTON.addEventListener('click', () => {
    MOBILE_BUTTON.classList.toggle('open');
    MAIN_MENU.classList.toggle('menu-open');
  });
  // Drupal Behaviors and Jquery here
  // Using jQuery here will help reduce the amount of conflicts between
  // admin interface and global JS functionality.
  Drupal.behaviors.tombras = {
    attach: function (context, settings) {
      //Can access all the drupal behaviors from here
    }
  }
}(Drupal, jQuery));
