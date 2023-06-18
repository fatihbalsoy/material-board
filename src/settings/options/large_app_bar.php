<?php
$large_app_bar = get_option('mdp_large_admin_bar');
$large_app_bar_variant = get_option('mdp_large_admin_bar_variant');
?>

<tr>
    <th scope='row'><?php _e('Large App Bar', 'wp-material-design') ?></th>
    <td>
        <input name="mdp_large_admin_bar" type="checkbox" <?php checked($large_app_bar, 'on') ?>>
        </input>
        <select name="mdp_large_admin_bar_variant">
            <option value="1" <?php selected($large_app_bar_variant, '1') ?>>
                <?php _e('Admin Bar on Top', 'wp-material-design') ?>
            </option>
            <option value="2" <?php selected($large_app_bar_variant, '2') ?>>
                <?php _e('Admin Menu on Top', 'wp-material-design') ?>
            </option>
        </select>
        <br></br>
        <div><b>
                <?php _e('Experimental', 'wp-material-design') ?>
            </b></div>
    </td>
</tr>