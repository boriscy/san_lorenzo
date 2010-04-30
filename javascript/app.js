jQuery(document).ready(
function($) {
  $('a[data-delete]').live("click", function(e) {
    $(this).parents("tr:first").addClass('marked');
    if(confirm('Esta seguro de borrar el item seleccionado')) {
      $(this).parents("tr:first").removeClass('marked');
      $(this).removeClass('marked');
      return true;
    }else{
      $(this).parents("tr:first").removeClass('marked');
      e.stopPropagation();
      return false;
    }
  });
    
});
