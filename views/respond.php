<?php

get_header();



// echo "<pre>";
// var_dump($wedding->party);
// echo "</pre>";
// die();

// var_dump();

?>

<h2><?php echo $wedding->party->name; ?></h2>

<div class="details">
    <?php echo $wedding->party->_guest_party_address1; ?><br />
    <?php if ($wedding->party->_guest_party_address2 != ''): ?>
    <?php echo $wedding->party->_guest_party_address1; ?><br />
    <?php endif; ?>
    <?php echo $wedding->party->_guest_party_city; ?>, <?php echo $wedding->party->_guest_party_state; ?> <?php echo $wedding->party->_guest_party_zip; ?>
</div>


<form method="post" action="/rsvp/respond/">
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Attending?</th>
            <th>Family Gathering?</th>            
        </tr>
    <?php foreach ($wedding->party->members as $guest): ?>
        <tr>
            <td>
                <input type="text" name="" value="" title="<?php echo $guest->first_name ?>" />
            </td>
            <td>
                <input type="text" name="" value="" title="<?php echo $guest->last_name ?>" />
            </td>
            <td>
                <input type="text" name="" value="" title="<?php echo $guest->user_email ?>" />
            </td>
            <td>
                <input type="checkbox" name="" value="0" />
            </td>
            <td>
                <input type="checkbox" name="" value="0" />
            </td>            
        </tr>

    <?php endforeach; ?>
    </table>
    
    <button type="text">Update</button>
    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            console.log($('input[type="text"]'));
          $('input[type="text"]').setFieldTitles();
        });
    </script>
    
</form>

<?php get_footer(); 

//var_dump($party);

?>