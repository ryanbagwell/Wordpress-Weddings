<tr data-id="<?php echo $guest->ID; ?>" <?php echo ($hidden)?'class="hidden"':''; ?>>
    <?php if (is_admin() && is_user_logged_in()):?>
    <td class="remove">X</td>
    <?php endif; ?>

    <td class="first-name">
        <input class="first-name" type="text" name="first_name" value="<?php echo $guest->first_name ?>" title="" rel="First Name" />
    </td>
    <td class="last-name">
        <input class="last-name" type="text" name="last_name" value="<?php echo $guest->last_name ?>" title="" rel="Last Name" />
    </td>
    <td class="email">
                        
        <input class="email" type="text" name="email" value="<?php echo (stristr($guest->email,'nothing.com'))?'':$guest->email ?>" title="" rel="Email" />
    </td>
    <td class="attending-wedding">
        <select class="attending-wedding" name="_attending_wedding"  rel="Wedding attendance" >
            <option value="">---</option>
            <option value="1" <?php echo ($guest->_attending_wedding == '1')?'selected="selected"':''; ?>>Yes</option>
            <option value="0" <?php echo ($guest->_attending_wedding == '0')?'selected="selected"':''; ?>>No</option>
        </select>
    </td>
    <td class="attending-dinner">
        <select class="attending-dinner" name="_attending_dinner" <?php echo ($guest->_attending_dinner == '1')?'selected="selected"':''; ?>>
            <option value="">---</option>
            <option value="1" <?php echo ($guest->_attending_dinner == '1')?'selected="selected"':''; ?>>Yes</option>
            <option value="0" <?php echo ($guest->_attending_dinner == '0')?'selected="selected"':''; ?>>No</option>
        </select>
    </td>            
</tr>