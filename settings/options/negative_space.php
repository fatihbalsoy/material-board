<!--
 *   negative_space.php
 *   material-board
 * 
 *   Created by Fatih Balsoy on 25 Dec 2023
 *   Copyright © 2023 Fatih Balsoy. All rights reserved.
-->

<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$negative_space = get_option('fbwpmdp_negative_space');
?>

<tr>
    <th scope='row'><?php esc_html_e('Content Padding', 'material-board') ?></th>
    <td>
        <input name="fbwpmdp_negative_space" type="checkbox" <?php checked($negative_space, 'on') ?> />
        <br /><br />
        <?php esc_html_e('Content padding can be beneficial for enhancing readability and improving overall visual appeal. Turning it off may ease the use of third-party plugins.', 'material-board') ?>
    </td>
</tr>