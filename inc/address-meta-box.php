<?php

$state_list = array('AL'=>"Alabama",
                'AK'=>"Alaska", 
                'AZ'=>"Arizona", 
                'AR'=>"Arkansas", 
                'CA'=>"California", 
                'CO'=>"Colorado", 
                'CT'=>"Connecticut", 
                'DE'=>"Delaware", 
                'DC'=>"District Of Columbia", 
                'FL'=>"Florida", 
                'GA'=>"Georgia", 
                'HI'=>"Hawaii", 
                'ID'=>"Idaho", 
                'IL'=>"Illinois", 
                'IN'=>"Indiana", 
                'IA'=>"Iowa", 
                'KS'=>"Kansas", 
                'KY'=>"Kentucky", 
                'LA'=>"Louisiana", 
                'ME'=>"Maine", 
                'MD'=>"Maryland", 
                'MA'=>"Massachusetts", 
                'MI'=>"Michigan", 
                'MN'=>"Minnesota", 
                'MS'=>"Mississippi", 
                'MO'=>"Missouri", 
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio", 
                'OK'=>"Oklahoma", 
                'OR'=>"Oregon", 
                'PA'=>"Pennsylvania", 
                'RI'=>"Rhode Island", 
                'SC'=>"South Carolina", 
                'SD'=>"South Dakota",
                'TN'=>"Tennessee", 
                'TX'=>"Texas", 
                'UT'=>"Utah", 
                'VT'=>"Vermont", 
                'VA'=>"Virginia", 
                'WA'=>"Washington", 
                'WV'=>"West Virginia", 
                'WI'=>"Wisconsin", 
                'WY'=>"Wyoming");

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
        <?php foreach ($state_list as $abbrev=>$name) {
            $selected = (get_post_meta($post->ID,'_guest_party_state',true) == $abbrev)?'selected="selected"':'';
            echo "<option value='$abbrev' $selected>$abbrev</option>";
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



