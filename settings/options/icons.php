<?php
$option = get_option('mdp_icons');
?>

<tr>
    <th scope='row'>Icons</th>
    <td>
        <select name="mdp_icons" id="icon-fonts" onchange="changeIcons()">
            <option value="md-icons" <?php selected($option, 'md-icons'); ?>>Material Icons</option>
            <option value="wordpress" <?php selected($option, 'wordpress'); ?>>WordPress Dashicons</option>
        </select>
        <br>
        <div class='mdwp-helper-text'>If you experience any issues with Material Icons, feel free to
            turn it off
            by switching to WordPress Dashicons</div>
    </td>
</tr>