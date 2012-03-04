<?php

get_header();


$party = $_SESSION['wedding_party'];
$members = $_SESSION['']

?>

<h2><?php echo $party->post_title; ?></h2>



<!-- <form method="post" action="/rsvp/login/">
    <label>Enter Your RSVP Code<label>
    <input type="text" name="reservation_code" value="" title="Reservation Code" />
    <button type="submit">Go</button>
</form> -->

<?php get_footer(); 

var_dump($party);

?>