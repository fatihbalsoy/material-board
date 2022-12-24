<?php
$divi_fix = get_option('mdp_toolbar_divi_fix');
?>

<tr>
    <th scope='row'>Toolbar</th>
    <td>
        <input name="mdp_toolbar_divi_fix" type="checkbox" <?php checked($divi_fix, 'on') ?>>Cover secondary menu in Divi Themes when toolbar is visible</input>
        <!-- <br> -->
        <!-- <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                <input type="checkbox" id="switch-1" class="mdl-switch__input" checked>
                <span class="mdl-switch__label"></span>
            </label> -->
    </td>
</tr>