<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$option = get_option('fbwpmdp_icons');
?>

<tr>
    <th scope='row'><?php esc_html_e('Icons', 'material-board') ?></th>
    <td>
        <select name="fbwpmdp_icons" id="icon-fonts" onchange="changeIcons()">
            <option value="md-icons" <?php selected($option, 'md-icons'); ?>>Material Icons</option>
            <option value="wordpress" <?php selected($option, 'wordpress'); ?>>WordPress Dashicons</option>
        </select>
        <br>
    </td>
</tr>