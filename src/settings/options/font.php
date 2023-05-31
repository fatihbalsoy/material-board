<?php
$option = get_option('mdp_font')
?>

<tr>
    <th scope='row'><?php _e('Font', 'wp-material-design') ?></th>
    <td>
        <select name="mdp_font" id="font-face" onchange="changeFontType()">
            <option value="roboto" <?php selected($option, 'roboto') ?>>Roboto</option>
            <option value="mona-sans" <?php selected($option, 'mona-sans') ?>>Mona Sans</option>
            <option value="hubot-sans" <?php selected($option, 'hubot-sans') ?>>Hubot Sans</option>
            <option value="wordpress" <?php selected($option, 'wordpress') ?>>
                <?php _e('WordPress Default', 'wp-material-design') ?></option>
        </select>
    </td>
</tr>