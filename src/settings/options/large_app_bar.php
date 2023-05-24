<?php
$large_app_bar = get_option('mdp_large_admin_bar');
$large_app_bar_variant = get_option('mdp_large_admin_bar_variant');
?>

<tr>
    <th scope='row'>Large App Bar</th>
    <td>
        <input name="mdp_large_admin_bar" type="checkbox" <?php checked($large_app_bar, 'on') ?>>
        Enlarges the app bar.
        </input>
        <br></br>
        <div>Variant</div>
        <select name="mdp_large_admin_bar_variant">
            <option value="1" <?php selected($large_app_bar_variant, '1') ?>>Admin Bar on Top</option>
            <option value="2" <?php selected($large_app_bar_variant, '2') ?>>Admin Menu on Top</option>
        </select>
        <br></br>
        <div><b>Experimental</b></div>
    </td>
</tr>