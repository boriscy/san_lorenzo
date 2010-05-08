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

  // Hide mask an dialogs
  function hideDialog() {
    $('#mask').hide();
    $('.dialog').hide();
    $('body').trigger("hide:dialog");
  }

  function showDialog(target) {
    $('#mask').show();
    $(target).show();
  }

  //$('div.dialog').bind("");
  $('.dialog .close').click(function(e) { 
     hideDialog();
   });
  $('#mask').click(function() { hideDialog() });

  $('.dialog').live("show:dialog", function(e) {
    var target = e.target || e.srcElement;
    showDialog(target);
  });

    
});

/**
 * Mark
 * @param String // jQuery selector
 * @param Integer velocity
 */
function mark(selector, velocity, val) {
  val = val || 0;
  $(selector).css({'background': 'rgb(255,255,'+val+')'});
  if(val >= 255)
    return false;
  setTimeout(function() {
    val+=5;
    mark(selector, velocity, val);
  }, velocity);
}
