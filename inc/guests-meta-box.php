<table class="weddings-list">

<?php if (count($guests) == 0): ?>

<tr><td>No guests found.</td></tr>

<?php else:
foreach($guests as $guest):
    $guest = get_userdata($guest->user_id); ?>
        <tr>
        <td><?php echo $guest->user_title; ?></td>
        <td><?php echo $guest->first_name; ?></td>
        <td><?php echo $guest->last_name; ?></td>
        <td><?php echo $guest->user_email; ?></td>
        </tr>
<?php endforeach; ?>

<?php endif; ?>

</table>

<div class="field-wrapper add-guest-form">    
    <select name="_new_guest_title-1">
        <option value="">---</option>
        <option value="Mr.">Mr.</option>
        <option value="Mr.">Mrs.</option>
        <option value="Mr.">Ms.</option>
    </select>

    <input type="text" class="new" rel="First Name" name="_new_guest_first_name-1" value="First Name" />
    <input type="text" class="new" rel="Last Name" name="_new_guest_last_name-1" value="Last Name" />
    <input type="text" class="new" rel ="Email" name="_new_guest_email-1" value="Email" />
</div>






