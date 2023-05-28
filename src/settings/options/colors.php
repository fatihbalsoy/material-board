<!--
* colors.php
* material-design-dashboard
*
* Created by Fatih Balsoy on 5/21/23
* Copyright © 2023 Fatih Balsoy. All rights reserved.
-->

<?php
$primary_option = get_option('mdp_colors_primary');
$accent_option = get_option('mdp_colors_accent');
?>

<tr>
    <th scope='row'><?php _e('Colors', 'wp-material-design') ?></th>
    <td>
        <div>
            <p> <?php _e('Primary (Toolbars and Navigations)', 'wp-material-design') ?> </p>
            <input type="color" id="primary-color" name="mdp_colors_primary" value="<?php echo $primary_option ?>"
                onchange="changePrimaryColor()">
        </div>
        <br>
        <div>
            <p> <?php _e('Accent (Text Selections and Controls)', 'wp-material-design') ?> </p>
            <input type="color" id="accent-color" name="mdp_colors_accent" value="<?php echo $accent_option ?>"
                onchange="changeAccentColor()">
        </div>
    </td>
</tr>