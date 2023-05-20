<?php
$options = get_option('mdp_theme');
?>

<tr>
    <th scope='row'>Theme</th>
    <td>
        <form name="mdp_theme">
            <input type="radio" name="mdp_theme" value="light" <?php checked('light' == $options) ?>> Light<br>
            <input type="radio" name="mdp_theme" value="dark" <?php checked('dark' == $options) ?>> Dark<br>
            <input type="radio" name="mdp_theme" value="auto" <?php checked('auto' == $options) ?>> System<br>
        </form>
        <div class='mdwp-helper-text'>Dark mode may not be compatible with third-party plugins.</div>
    </td>
</tr>