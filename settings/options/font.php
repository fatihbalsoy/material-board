<?php
$option = get_option('mdp_font')
?>

<tr>
    <th scope='row'>Font</th>
    <td>
        <select name="mdp_font" id="font-face" onchange="changeFontType()">
            <option value="mona-sans" <?php selected($option, 'mona-sans') ?>>Mona Sans</option>
            <option value="hubot-sans" <?php selected($option, 'hubot-sans') ?>>Hubot Sans</option>
            <option value="roboto" <?php selected($option, 'roboto') ?>>Roboto</option>
            <option value="wordpress" <?php selected($option, 'wordpress') ?>>WordPress Default</option>
        </select>
    </td>
</tr>