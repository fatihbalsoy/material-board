<?php
$primary_option = get_option('mdp_colors_primary');
$accent_option = get_option('mdp_colors_accent');
?>

<tr>
    <th scope='row'>Colors</th>
    <td>
        <div>
            <p> Primary (Toolbars and Navigations) </p>
            <input type="color" id="primary-color" name="mdp_colors_primary" value="<?php echo $primary_option ?>" onchange="changePrimaryColor()">
        </div>
        <br>
        <div>
            <p> Accent (Text Selections and Controls) </p>
            <input type="color" id="accent-color" name="mdp_colors_accent" value="<?php echo $accent_option ?>" onchange="changeAccentColor()">
        </div>
    </td>
</tr>