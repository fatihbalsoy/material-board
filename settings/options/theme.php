<?php
$options = get_option('mdp_theme');
?>

<input type="radio" name="mdp_theme" value="light" <?php checked('light' == $options) ?>> Light<br>
<input type="radio" name="mdp_theme" value="dark" <?php checked('dark' == $options) ?>> Dark<br>
<input type="radio" name="mdp_theme" value="auto" <?php checked('auto' == $options) ?>> System<br>
<div class='mdwp-helper-text'>We do not suggest turning on dark mode, it might make it difficult to read
    text in third-party plugins.</div>