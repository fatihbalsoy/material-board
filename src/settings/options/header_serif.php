<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$header_serif = get_option('fbwpmdp_header_serif_font');
?>

<tr>
    <th scope='row'><?php esc_html_e('Serif Header', 'material-board') ?></th>
    <td>
        <input name="fbwpmdp_header_serif_font" type="checkbox" <?php checked($header_serif, 'on') ?> />
        <br /><br />
        <?php esc_html_e('Enhance your headers with an editorial touch by enabling serif fonts.', 'material-board') ?>
    </td>
</tr>