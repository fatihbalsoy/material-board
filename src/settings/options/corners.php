<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$rounded_corners = get_option('fbwpmdp_rounded_corners');
?>

<tr>
    <th scope='row'><?php esc_html_e('Rounded Corners', 'material-board') ?></th>
    <td>
        <input name="mdp_rounded_corners" type="checkbox" <?php checked($rounded_corners, 'on') ?> />
        <br /><br />
        <?php esc_html_e('You can choose to turn on or off the rounded corners around cards, buttons, and text fields.', 'material-board') ?>
    </td>
</tr>