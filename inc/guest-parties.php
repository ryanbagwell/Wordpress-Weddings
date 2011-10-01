
<div class="wrap">

    <h2>Guest Parties</h2>
    
    <table class="wp-list-table widefat fixed posts" cellspacing="0">

    	<thead>
    	    <th>Party Name</th>
    	    <th>Address 1</th>
    	    <th>Address 2</th>
    	    <th>City</th>
    	    <th>State</th>
    	    <th>ZIP</th>
    	    <th>Email</th>	    	    
    	</thead>


        <tbody id="the-list">
        
            <?php foreach($parties as $party): ?>
                <tr>
                <td class="party-name"><?php echo $party->post_title; ?></td>
            
                <?php foreach ($party->fields as $field): ?>
                    <td class="<?php echo $field; ?>"><?php echo $party->$field; ?></td>
                <?php endforeach; ?>

                </tr>
            <?php endforeach; ?>
        
        </tbody>
    </table>

</div>