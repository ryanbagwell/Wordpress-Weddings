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
    <?php $guests = $wedding->party->guests; ?>

    <table>
    <?php require_once(dirname(__FILE__).'/_guest_form_fields.php'); ?>
    </table>

    <h3>All Done? <a href="/rsvp/login/">Click here to Log Out</a></h3>
    <input type="hidden" name="token" value="<?php echo $wedding->party->_guest_party_token; ?>" />
    
    <script type="text/javascript" src="<?php echo plugins_url('/js/ajax-update.js',dirname(__FILE__).'../'); ?>"></script>    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input').rsvp();
        });
    </script>
    
</form>

</div><!-- content -->

<?php get_footer(); 



?>