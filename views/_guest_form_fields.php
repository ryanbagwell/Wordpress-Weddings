
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Attending?</th>
            <th>
                Sunday Gathering?
                <a href="" target="_blank">(What's this?)</a>
            </th>            
        </tr>
    </thead>
    <tbody>

<?php
foreach ($guests as $guest):

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
