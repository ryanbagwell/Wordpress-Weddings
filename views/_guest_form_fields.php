<table class="weddings-list">

    <thead>
        <tr>
            <?php if (is_admin() && is_user_logged_in()): ?>
            <td></td>
            <?php endif; ?>            
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
    <tbody data-party="<?php echo $post->ID; ?>">
        
    <?php
    if (count($guests) > 0) {
        foreach ($guests as $guest):
            $wedding->print_guest_row($guest,true);
        endforeach;
    } else {
        $colcount = (is_user_logged_in())?'6':'5';
        echo "<tr><td colspan='$colcount'></td></tr>";
        
        if (is_admin())
        $this->print_guest_row(new StdClass(),true);
    }

    ?>
    </tbody>
</table>
