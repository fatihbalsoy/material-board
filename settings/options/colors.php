<?php
$primary_option = get_option('mdp_colors_primary');
$accent_option = get_option('mdp_colors_accent');
?>

<tr>
    <th scope='row'>Colors</th>
    <td>
        Primary Color:<br>
        <input type="text" name="mdp_colors_primary" id='primary-color' placeholder="Teal" value="<?php echo $primary_option ?>" onchange="changePrimaryColor()" /><br>
        <div class='mdwp-helper-text'>Toolbars and Navigations</div>
        <br>
        <br>
        Accent Color:<br>
        <input type="text" name="mdp_colors_accent" id='accent-color' placeholder="Crimson" value="<?php echo $accent_option ?>" onchange="changeAccentColor()" /><br>
        <div class='mdwp-helper-text'>Text Selections and Controls</div>
    </td>
</tr>