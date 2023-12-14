<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$large_app_bar = get_option('fbwpmdp_large_admin_bar');
$large_app_bar_variant = get_option('fbwpmdp_large_admin_bar_variant');
?>

<tr>
    <th scope='row'><?php esc_html_e('Large App Bar', 'material-board') ?></th>
    <td>
        <input name="fbwpmdp_large_admin_bar" type="checkbox" <?php checked($large_app_bar, 'on') ?>>
        </input>
        <select name="fbwpmdp_large_admin_bar_variant">
            <option value="1" <?php selected($large_app_bar_variant, '1') ?>>
                <?php esc_html_e('Admin Bar on Top', 'material-board') ?>
            </option>
            <option value="2" <?php selected($large_app_bar_variant, '2') ?>>
                <?php esc_html_e('Admin Menu on Top', 'material-board') ?>
            </option>
        </select>
        <br></br>
        <div><b>
                <?php esc_html_e('Experimental', 'material-board') ?>
            </b></div>
    </td>
</tr>