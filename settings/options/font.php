<?php
$option = get_option('mdp_font')
?>

<tr>
    <th scope='row'>Font</th>
    <td>
        <select name="mdp_font" id="font-face" onchange="changeFontType()">
            <option value="roboto" <?php selected($option, 'roboto') ?>>Roboto</option>
            <option value="product-sans" <?php selected($option, 'product-sans') ?>>Product Sans</option>
            <option value="wordpress" <?php selected($option, 'wordpress') ?>>WordPress Default</option>
        </select>
    </td>
</tr>