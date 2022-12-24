<?php
$option = get_option('mdp_colors_accent');
?>

<input type="text" name="mdp_colors_accent" id='primary-color' placeholder="Crimson" value="<?php echo $option ?>" onchange="changeAccentColor()" /><br>
<div class='mdwp-helper-text'>Text Selections and Controls</div>