/**
 * Created with JetBrains PhpStorm.
 * User: grzybu
 * Date: 23.09.12
 * Time: 16:28
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(
  function() {
      var navOpt = {
          fillSpace : true,
          navigation: true
      };
      $('.navigation').accordion(navOpt);

      $('.navigation a.clickable').click(function() {
          window.location = $(this).attr('href');

          return false;

      });

      $('.ui-button').button();
  }
);