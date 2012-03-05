/**
 * jQuery.setFieldTitles
 * Copyright (c) 2012 Ryan Bagwell ryan(at)ryanbagwell(dot)com | http://www.ryanbagwell.com
 * Dual licensed under MIT and GPL.
  *
 * @projectDescription Sets input fields to the element's "title" attribute, clears it on focus, and restores it on blur if the use doesn't add it.
 *
 * @author Ryan Bagwell
 * @version 1.0
 */
 
(function( $ ) {
  
    var methods = {
        showTitle: function() {
         if ($(this).val() == '')
             $(this).val($(this).attr('title'));
        },
        clearTitle: function() {
            
         if ($(this).val() == $(this).attr('title'))
             $(this).val('');
        }
    };
    
  $.fn.setFieldTitles = function() {
       
      this.each(function() {
         methods.showTitle.apply(this); 
      });
          
      this.focus(function() {
          methods.clearTitle.apply(this);
      });
      
      this.blur(function() {
          methods.showTitle.apply(this);
      });
  };
  
})( jQuery );