<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$options = get_option('fbwpmdp_theme');
?>

<tr>
    <th scope='row'>
        <?php esc_html_e('Theme', 'material-board') ?>
    </th>
    <td>
        <form name="fbwpmdp_theme">
            <input type="radio" name="fbwpmdp_theme" value="light" <?php checked('light' == $options) ?>>
            <?php esc_html_e('Light', 'material-board') ?>
            <br>
            <input type="radio" name="fbwpmdp_theme" value="dark" <?php checked('dark' == $options) ?>>
            <?php esc_html_e('Dark', 'material-board') ?>
            <br>
            <input type="radio" name="fbwpmdp_theme" value="auto" <?php checked('auto' == $options) ?>>
            <?php esc_html_e('System', 'material-board') ?>
            <br>
        </form>
        <br />
        <div class='mdwp-helper-text'>
            <?php esc_html_e('Dark mode may not be compatible with third-party plugins.', 'material-board') ?>
        </div>
    </td>
</tr>