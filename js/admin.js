jQuery(document).ready(function($) {

   $('.add-guest-form input').focus(function() {
       if ($(this).val() == $(this).attr('rel')) {
           $(this).removeClass('new').val('');
       }
   });
   
   $('.add-guest-form input').blur(function() {
       if ($(this).val() == "") {
           $(this).addClass('new').val($(this).attr('rel'));
       }
   });
   
   $('#add-guest-link').click(function() {
       if ($('.add-guest-form:visible').length) {           
           var newDiv = $('.add-guest-form').last().clone(true);
           
           $(newDiv).find('input').each(function() {
               $(this).val($(this).attr('rel'));
           }).addClass('new');
            
          
           $('.add-guest-form:last').after(newDiv);
            
            //update the field name id numbers
            $('.add-guest-form').each(function(i) {
                var indexCount = i;
                $(this).find('input, select').each(function() {
                    var name = $(this).attr('name').split('-');
                    $(this).attr('name',name[0] + '-' + indexCount);
                    
                });
                
                //console.log(name);
                
            });
        
       } 
       
       $('.add-guest-form').show();
          
   });
   
   //clear the name form before submitting
   $('form').submit(function() {
       $('.add-guest-form input').each(function() {
           if ($(this).val() == $(this).attr('rel')) {
               $(this).val('');
        }
    });
       
   });
   
});