<table class="weddings-list">

    <thead>
        <tr>
            <?php if (is_admin() && is_user_logged_in()): ?>
            <td></td>
            <?php endif; ?>            
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Attending?</th>
            <th>
                Sunday Pregame?<br />
                <a href="/pregame-gathering/" target="_blank">(What's this?)</a>
            </th>            
        </tr>
    </thead>
    <tbody data-party="<?php echo (is_admin())?$post->ID:$wedding->party->ID; ?>">
        
    <?php
    if (count($guests) > 0) {
        foreach ($guests as $guest):
            include('_guest_table_row.php');
        endforeach;
    } else {
        $colcount = (is_user_logged_in())?'6':'5';
        echo "<tr><td colspan='$colcount'>No Guests Found</td></tr>";
        
        if (is_admin())
            $hidden = true;
            include('_guest_table_row.php');
    }

    ?>
    </tbody>
</table>

<script type="text/javascript" src="<?php echo plugins_url('/js/ajax-update.js',dirname(__FILE__).'../'); ?>"></script>    
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.weddings-list').rsvp();
        
        $('<span />').addClass('updated').css({
            'display':'none',
            'color':'green',
            'font-size':'12px',
            'float':'right',
        }).appendTo('#guests h3');


       $('#add-guest-link').click(function() {
          var newRow = $('.weddings-list').find('tr').last().clone();
          newRow.find('input').val('');
          newRow.attr('data-id','');
          newRow.find('select option').removeAttr('selected');
          newRow.css('display','none').appendTo('.weddings-list tbody').fadeIn(500).rsvp();
       });

    });
</script>