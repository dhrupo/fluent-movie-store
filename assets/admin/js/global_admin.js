/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/admin/global_admin.js ***!
  \*****************************************/
jQuery(document).ready(function ($) {
  var $handHeld = $('.fframe_handheld');
  $handHeld.on('click', function () {
    $(this).parent().find('.fframe_menu').toggleClass('fframe_menu_open');
  });
  $('.fframe_menu_item a').on('click', function () {
    $handHeld.parent().find('.fframe_menu').removeClass('fframe_menu_open');
  });
  jQuery('.update-nag,.notice, #wpbody-content > .updated, #wpbody-content > .error').remove();
});
/******/ })()
;
//# sourceMappingURL=global_admin.js.map