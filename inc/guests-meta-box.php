<table class="weddings-list">

<?php if (count($guests) == 0): ?>

<tr><td>No guests found.</td></tr>

<?php else:

    require_once(dirname(__FILE__).'/../views/_guest_form_fields.php'); ?>
    
<?php endif; ?>

</table>

<script type="text/javascript" src="<?php echo plugins_url('/js/ajax-update.js',dirname(__FILE__).'../'); ?>"></script>    
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.weddings-list input').rsvp();
        $('<span />').addClass('updated').css({
            'display':'none',
            'color':'green',
            'font-size':'12px',
            'float':'right',
            
        }).appendTo('#guests h3');
        
    });
</script>
