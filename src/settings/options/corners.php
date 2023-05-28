<?php
$rounded_corners = get_option('mdp_rounded_corners');
?>

<tr>
    <th scope='row'><?php _e('Rounded Corners', 'wp-material-design') ?></th>
    <td>
        <input name="mdp_rounded_corners" type="checkbox" <?php checked($rounded_corners, 'on') ?>>
        <?php _e('You can choose to turn on or off the rounded corners around cards, buttons, and text fields.', 'wp-material-design') ?>
        </input>
    </td>
</tr>