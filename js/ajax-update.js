(function( $ ) {
    
    var methods = {
        init:function() {
            $(this).click(function() {
                methods.update.apply(this);
            });            
        },
        update:function() {
            var data = methods.getData.apply(this);
            var resp = methods.send(data);
        },
        getData:function() {

            var value = $(this).val();

            if ($(this).prop('checked'))
                value = 1;

            var data = {
                action:'rsvp_update',
                id:$(this).parents('tr').attr('data-id'),
                name:$(this).attr('name'),
                value:value,
                token:$('input[name="token"]').val()
            }
            
            return data;
            
        },
        send:function(data) {
            var response;
            
            $.post('/wp-admin/admin-ajax.php',data,function(resp) {
                methods.handleResponse(resp,data);
            });
            
            return response;
        },
        handleResponse:function(resp,data) {
            var row = $('tr[data-id="'+data.id+'"]');
            var input = row.find('[name="'+data.name+'"]');
            
            if (resp == 'ok') {
                var title = input.attr('rel');
                $('span.updated').text(title + ' updated!').css('display','inline-block').delay(2000).fadeOut('fast');                        
            }            
            
        }
    
    };
    
    
    
      $.fn.rsvp = function() {

          this.each(function() {
             methods.init.apply(this); 
          });

      };

})( jQuery );    
    