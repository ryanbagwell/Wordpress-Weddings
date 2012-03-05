<?php

get_header();



// echo "<pre>";
// var_dump($wedding->party);
// echo "</pre>";
// die();
// 
// var_dump();

?>

<div id="content" class="rsvp">

<h1>Confirm your attendance</h1>

<h3><?php echo $wedding->party->name; ?></h3>

<div class="details">
    <?php echo $wedding->party->_guest_party_address1; ?><br />
    <?php if ($wedding->party->_guest_party_address2 != ''): ?>
    <?php echo $wedding->party->_guest_party_address1; ?><br />
    <?php endif; ?>
    <?php echo $wedding->party->_guest_party_city; ?>, <?php echo $wedding->party->_guest_party_state; ?> <?php echo $wedding->party->_guest_party_zip; ?>
</div>

<h3>Tell us who will be attending:<span class="updated" style="display: none;">Updated!</span></h3>

<form method="post" action="/rsvp/respond/" id="rsvp-form">
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Attending?</th>
                <th>
                    Family Gathering?<br/>
                    <a href="" target="_blank">(What's this?)</a>
                </th>            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wedding->party->guests as $guest): 

                //check for a dummy email address
                if (stripos($guest->user_email,'nothing') !== false) {
                    $email = '';
                } else {
                    $email = $guest->user_email;
                }
            
            ?>
            <tr data-id="<?php echo $guest->ID; ?>">
                <td class="first-name">
                    <input class="first-name" type="text" name="first_name" value="<?php echo $guest->first_name ?>" title="" rel="First Name" />
                </td>
                <td class="last-name">
                    <input class="last-name" type="text" name="last_name" value="<?php echo $guest->last_name ?>" title="" rel="Last Name" />
                </td>
                <td class="email">
                    <input class="email" type="text" name="email" value="<?php echo $email ?>" title="" rel="Email" />
                </td>
                <td class="attending-wedding">
                    <input class="attending-wedding" type="checkbox" name="_attending_wedding" value="0" rel="Wedding attendance" <?php echo ($guest->_attending_wedding === '1')?'checked="checked"':''; ?> />
                </td>
                <td class="attending-dinner">
                    <input class="attending-dinner" type="checkbox" name="_attending_dinner" value="0" rel="Dinner attendance" <?php echo ($guest->_attending_dinner === '1')?'checked="checked"':''; ?> />
                </td>            
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3>All Done? <a href="/rsvp/login/">Click here to Log Out</a></h3>
    <input type="hidden" name="token" value="<?php echo $wedding->party->_guest_party_token; ?>" />
    
    <!-- <button type="text">Update</button> -->
    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            //$('input[type="text"]').setFieldTitles();
        
        
            $('input').change(function() {
                var me = this;
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
                
                $.post('/wp-admin/admin-ajax.php',data,function(response) {
                    
                    if (response == 'ok') {
                        var title = $(me).attr('rel');
                        $('span.updated').text(title + ' updated!').css('display','inline-block').delay(2000).fadeOut('fast');                        
                    }

                });
                
            });
        
        });
    </script>
    
</form>

</div><!-- content -->

<?php get_footer(); 



?>