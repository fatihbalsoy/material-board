<?php
$option = get_option('mdp_colors_primary');
?>

<input type="text" name="mdp_colors_primary" id='accent-color' placeholder="Teal" value="<?php echo $option ?>" onchange="changePrimaryColor()" /><br>
<div class='mdwp-helper-text'>Toolbars and Navigations</div>