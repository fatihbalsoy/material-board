<?php

function get_local_file_contents($file_path)
{
    ob_start();
    include $file_path;
    $contents = ob_get_clean();

    return $contents;
}
?>

<!-- <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-red.min.css" /> -->
<link rel="stylesheet" href="/wp-content/plugins/material-design-dashboard/settings/style.css" />
<script defer src="https://cdn.rawgit.com/bgrins/TinyColor/master/tinycolor.js"></script>
<!-- <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> -->
<script defer src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script defer src="/wp-content/plugins/material-design-dashboard/settings/script.js"></script>

<meta name="theme-color" content="#fff">
<div class='wrap'>
    <div class='mdwp-card mdwp-elevation1 mdwp-primary-back mdwp-card-header'>
        <div class='mdwp-header-title'>
            Material Design for WordPress Dashboard
        </div>
        Developed by <a href="https://fatih.bal.soy/">Fatih Balsoy</a> | Version 1.0 | <a href="https://github.com/fatihbalsoy/wp-material-design/issues/new">Request Features & Report Issues</a>
    </div>
    <form action="options.php" method="POST">
        <?php
        settings_fields('material_dashboard_plugin');
        ?>

        <div class='mdwp-content-center'>
            <div class='mdwp-card mdwp-first-card mdwp-elevation1 mdwp-light-back'>

                <div class='mdwp-card-title'>
                    Appearance
                </div>
                <table class='form-table'>
                    <tbody>
                        <?php
                        echo get_local_file_contents('options/theme.php');
                        echo get_local_file_contents('options/colors.php');
                        echo get_local_file_contents('options/font.php');
                        echo get_local_file_contents('options/icons.php');
                        echo get_local_file_contents('options/toolbar.php');
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- <p class="submit">
            <input style="background:var(--accent-color); color:#fff;" type="submit" name="submit" id="submit" class="button mdwp-button" value="Save Changes">
        </p> -->
            <?php
            submit_button();
            ?>
        </div>

    </form>

</div>