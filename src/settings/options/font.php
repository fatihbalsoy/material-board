<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$option = get_option('fbwpmdp_font')
?>

<tr>
    <th scope='row'><?php esc_html_e('Font', 'material-board') ?></th>
    <td>
        <select name="fbwpmdp_font" id="font-face" onchange="changeFontType()">
            <option value="dm-sans" <?php selected($option, 'dm-sans') ?>>DM Sans</option>
            <option value="figtree" <?php selected($option, 'figtree') ?>>Figtree</option>
            <option value="outfit" <?php selected($option, 'outfit') ?>>Outfit</option>
            <option value="roboto" <?php selected($option, 'roboto') ?>>Roboto</option>
            <option value="mona-sans" <?php selected($option, 'mona-sans') ?>>Mona Sans</option>
            <option value="hubot-sans" <?php selected($option, 'hubot-sans') ?>>Hubot Sans</option>
            <option value="wordpress" <?php selected($option, 'wordpress') ?>>
                <?php esc_html_e('WordPress Default', 'material-board') ?></option>
        </select>
    </td>
</tr>