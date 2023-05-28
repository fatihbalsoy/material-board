<?php
$option = get_option('mdp_icons');
?>

<tr>
    <th scope='row'><?php _e('Icons', 'wp-material-design') ?></th>
    <td>
        <select name="mdp_icons" id="icon-fonts" onchange="changeIcons()">
            <option value="md-icons" <?php selected($option, 'md-icons'); ?>>Material Icons</option>
            <option value="wordpress" <?php selected($option, 'wordpress'); ?>>WordPress Dashicons</option>
        </select>
        <br>
    </td>
</tr>