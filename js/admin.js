jQuery(document).ready(function($) {
   
   $('#add-guest-link').click(function() {
      var newRow = $('.weddings-list').find('tr').last().clone();
      newRow.find('input[type="text"]').val('');
      newRow.find('input[type="checkbox"]').val('0').prop('checked',false);
      
      newRow.css('display','none').appendTo('.weddings-list tbody').fadeIn(500);
                 
   });
   
   
});