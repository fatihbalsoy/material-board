<?php
$rounded_corners = get_option('mdp_rounded_corners');
?>

<tr>
    <th scope='row'>Rounded Corners</th>
    <td>
        <input name="mdp_rounded_corners" type="checkbox" <?php checked($rounded_corners, 'on') ?>>You can choose to
        turn on or off the rounded corners around cards, buttons, and text fields.</input>
    </td>
</tr>