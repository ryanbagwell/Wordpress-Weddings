(function( $ ) {
    
    var methods = {
        init:function() {
            
            $(this).find('input,select').change(function() {
                methods.update.apply(this);
            });
            
            $(this).find('.remove').click(function() {
                methods.remove.apply(this);
            });
           
        },
        update:function() {
            var data = methods.getData.apply(this);
            var resp = methods.send.apply(this,[data]);
        },
        getData:function() {

            var data = {
                action:'rsvp_update',
                id:$(this).parents('tr').attr('data-id'),
                token:$('input[name="token"]').val(),
                first_name:$(this).parents('tr').find('input.first-name').val(),
                last_name:$(this).parents('tr').find('input.last-name').val(),
                email:$(this).parents('tr').find('input.email').val(),
                _attending_wedding:$(this).parents('tr').find('select.attending-wedding').val(),
                _attending_dinner:$(this).parents('tr').find('select.attending-dinner').val(),
                _wedding_party:$(document).find('[data-party]').attr('data-party')                           
            }
  
            return data;
            
        },
        send:function(data) {
            var response;
            var _me = this;
         
            $.post('/wp-admin/admin-ajax.php',data,function(resp) {
                methods.handleResponse.apply(_me,[resp]);
            },'json');
            
            return response;
        },
        remove:function() {
            var _me = this;
            
            var data = {
                id:$(this).parent('tr').attr('data-id'),
                action:'remove_guest'
            }
            
            $.post('/wp-admin/admin-ajax.php',data,function(resp) {
                methods.handleResponse.apply(_me,[resp]);
            });            
        },
        handleResponse:function(resp) {
          
            if (resp == 'removed') {
                $(this).parent().fadeOut();
                return;
            }
            
            if (resp.id != '') {
                $(this).parent().parent().attr('data-id',resp.id);
            }
            
            $('span.updated').text('Updated!').css('display','inline-block').delay(2000).fadeOut('fast');   
            
        }
    
    };
    
    
      $.fn.rsvp = function() {
          
          this.each(function() {
             methods.init.apply(this); 
          });
          
      };

})( jQuery );    
    