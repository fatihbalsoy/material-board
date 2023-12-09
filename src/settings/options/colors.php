<!--
* colors.php
* material-design-dashboard
*
* Created by Fatih Balsoy on 5/21/23
* Copyright © 2023 Fatih Balsoy. All rights reserved.
-->

<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$primary_option = get_option('fbwpmdp_colors_primary');
$accent_option = get_option('fbwpmdp_colors_accent');
?>

<tr>
    <th scope='row'><?php esc_html_e('Colors', 'material-board') ?></th>
    <td>
        <div>
            <p> <?php esc_html_e('Primary (Toolbars and Navigations)', 'material-board') ?> </p>
            <input type="color" id="primary-color" name="mdp_colors_primary" value="<?php echo esc_attr($primary_option) ?>"
                onchange="changePrimaryColor()">
        </div>
        <br>
        <div>
            <p> <?php esc_html_e('Accent (Text Selections and Controls)', 'material-board') ?> </p>
            <input type="color" id="accent-color" name="mdp_colors_accent" value="<?php echo esc_attr($accent_option) ?>"
                onchange="changeAccentColor()">
        </div>
    </td>
</tr>