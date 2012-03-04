<?php
/*
 Template Name: Contact form page
 */
 
get_header();

?>

<?php

if ($_SESSION['message']) {
    echo $_SESSION['message'];
}


?>

<form method="post" action="/rsvp/login/">
    <label>Enter Your RSVP Code<label>
    <input type="text" name="reservation_code" value="" title="Reservation Code" />
    <button type="submit">Go</button>
</form>

<?php get_footer(); ?>