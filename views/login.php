<?php
/*
 Template Name: Contact form page
 */
 
get_header();

?>

<div id="content" class="rsvp">

    <h1>Respond Online</h1>

    <form method="post" action="/rsvp/login/" id="login-form">
        <label>Enter the RSVP code printed on the back of your invitation<label><br />
        <input type="text" name="reservation_code" value="" title="Reservation Code" />
        <button type="submit">Start &raquo;</button>
    </form>

    <p style="color: red">
    <?php
        if ($_SESSION['message'])
            echo $_SESSION['message'];
    ?>
    </p>

</div>

<?php get_footer(); ?>

