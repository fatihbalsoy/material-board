<?php
$header_serif = get_option('mdp_header_serif_font');
?>

<tr>
    <th scope='row'>Header Serif Font</th>
    <td>
        <input name="mdp_header_serif_font" type="checkbox" <?php checked($header_serif, 'on') ?>>To create a
        distinctive editorial style for your dashboard, consider using a serif font solely for the header.</input>
    </td>
</tr>