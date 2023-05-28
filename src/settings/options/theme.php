<?php
$options = get_option('mdp_theme');
?>

<tr>
    <th scope='row'>
        <?php _e('Theme', 'wp-material-design') ?>
    </th>
    <td>
        <form name="mdp_theme">
            <input type="radio" name="mdp_theme" value="light" <?php checked('light' == $options) ?>>
            <?php _e('Light', 'wp-material-design') ?>
            <br>
            <input type="radio" name="mdp_theme" value="dark" <?php checked('dark' == $options) ?>>
            <?php _e('Dark', 'wp-material-design') ?>
            <br>
            <input type="radio" name="mdp_theme" value="auto" <?php checked('auto' == $options) ?>>
            <?php _e('System', 'wp-material-design') ?>
            <br>
        </form>
        <div class='mdwp-helper-text'>
            <?php _e('Dark mode may not be compatible with third-party plugins.', 'wp-material-design') ?>
        </div>
    </td>
</tr>