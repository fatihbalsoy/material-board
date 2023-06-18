<?php
$header_serif = get_option('mdp_header_serif_font');
?>

<tr>
    <th scope='row'><?php _e('Serif Header', 'wp-material-design') ?></th>
    <td>
        <input name="mdp_header_serif_font" type="checkbox" <?php checked($header_serif, 'on') ?> />
        <br /><br />
        <?php _e('Enhance your headers with an editorial touch by enabling serif fonts.', 'wp-material-design') ?>
    </td>
</tr>