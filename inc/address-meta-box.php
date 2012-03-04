<?php
$states = array( "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC",  
      "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA",  
      "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",  
      "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC",  
      "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");
?>

<div class="field-wrapper">
    <label for="">Address Line 1</label>
    <input type="text" name="_guest_party_address1" value="<?php echo get_post_meta($post->ID,'_guest_party_address1',true); ?>" />
</div>

<div class="field-wrapper">
    <label for="">Address Line 2</label> 
    <input type="text" name="_guest_party_address2" value="<?php echo get_post_meta($post->ID,'_guest_party_address2',true); ?>" />
</div>

<div class="field-wrapper">
    <label for="">City</label>
    <input type="text" name="_guest_party_city" value="<?php echo get_post_meta($post->ID,'_guest_party_city',true); ?>" />
</div>


<div class="field-wrapper">
    <label for="">State</label>
    <select name="_guest_party_state">
        <?php foreach ($states as $state) {
            $selected = (get_post_meta($post->ID,'_guest_party_state',true) == $state)?'selected="selected"':'';
            echo "<option value='$state' $selected>$state</option>";
        }
        ?>
    </select>
</div>

<div class="field-wrapper">
    <label for="">ZIP</label>
    <input type="text" name="_guest_party_zip" value="<?php echo get_post_meta($post->ID,'_guest_party_zip',true); ?>" />
</div>

<div class="field-wrapper">
    <label for="">Contact Email</label>
    <input type="text" name="_guest_party_email" value="<?php echo get_post_meta($post->ID,'_guest_party_email',true); ?>" />
</div>

<div class="field-wrapper">
    <label for="">Access Code</label>
    <input type="text" name="_guest_party_token" value="<?php echo get_post_meta($post->ID,'_guest_party_token',true); ?>" readonly="readonly" />
</div>



