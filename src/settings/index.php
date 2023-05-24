<!--
* index.php
* settings
*
* Created by Fatih Balsoy on 4/14/23
* Copyright © 2023 Fatih Balsoy. All rights reserved.
-->

<?php

function get_local_file_contents($file_path)
{
    ob_start();
    include $file_path;
    $contents = ob_get_clean();

    return $contents;
}

// Check whether instance has curl installed and enabled.
// For instance, the expiremental Wordpress Playground project running on WebAssembly does not have curl enabled.
function curl_exists()
{
    return function_exists('curl_version');
}

/** CHECK FOR UPDATES (GITHUB) **/
if (curl_exists()) {
    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $GLOBALS["fb_mdp_plugin_github_releases"]);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // $output contains the output string
    $output = curl_exec($ch);
    $github_json_obj = json_decode($output);
    $github_latest_release = $github_json_obj[0]->tag_name;

    // close curl resource to free up system resources
    curl_close($ch);
}

?>

<!-- Page-specific stylesheet -->
<link rel="stylesheet" href="<?php echo ($GLOBALS["fb_mdp_plugin_directory"]) ?>/settings/style.css" />

<!-- TODO: Implement instant preview -->
<!-- <script defer src="script.js"></script> -->
<!-- <script defer src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
<!-- <script defer src="https://cdn.rawgit.com/bgrins/TinyColor/master/tinycolor.js"></script> -->

<div class='wrap'>
    <!-- Update Banner -->
    <?php
    if (curl_exists() and $github_latest_release != "v" . $GLOBALS["fb_mdp_plugin_version"]) {
        echo '
        <div class="update-nag notice notice-warning inline"><a href="' . $GLOBALS["fb_mdp_plugin_github"] . '/releases/tag/' . $github_latest_release . '">' . $GLOBALS["fb_mdp_plugin_settings_title"] . ' ' . $github_latest_release . '</a> is available! <a href="' . $GLOBALS["fb_mdp_plugin_github"] . '/releases" aria-label="Please update Material Design Dashboard now">Please update now</a>.</div>
        ';
    }
    ?>

    <!-- HEADER -->
    <!-------------------------------------------------------------------------------->
    <!-- Material Dashboard                                                         -->
    <!-- Developed by [Author] | Version | Request Features & Report Issues         -->
    <!-------------------------------------------------------------------------------->
    <div>
        <h1 class='wp-heading-inline'>
            <?php echo $GLOBALS["fb_mdp_plugin_settings_title"] ?>
        </h1>
    </div>

    <div class="wp-header-end"></div>

    <!-- OPTIONS -->
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
                        // Theme            - Light
                        //                  - Dark
                        //                  - System
                        echo get_local_file_contents('options/theme.php');
                        // Colors           - Primary
                        //                  - Accent
                        echo get_local_file_contents('options/colors.php');
                        // Rounded Corners  - Checkbox
                        echo get_local_file_contents('options/corners.php');
                        // Font             - Mona Sans
                        //                  - Hubot Sans
                        //                  - Roboto
                        //                  - Wordpress Default
                        echo get_local_file_contents('options/font.php');
                        // Header Serif     - Checkbox
                        echo get_local_file_contents('options/header_serif.php');
                        // Icons            - Material Icons
                        //                  - Wordpress Dashicons
                        echo get_local_file_contents('options/icons.php');
                        // Large App Bar    - Checkbox
                        //                  - Options
                        //                      - Admin Bar on Top
                        //                      - Admin Menu on Top
                        echo get_local_file_contents('options/large_app_bar.php');
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Save Changes -->
            <?php
            submit_button();
            ?>
            <div>
                Developed by <a
                    href="<?php echo $GLOBALS["fb_mdp_plugin_author_website"] ?>"><?php echo $GLOBALS["fb_mdp_plugin_author"] ?></a>
                | Version
                <?php echo $GLOBALS["fb_mdp_plugin_version"] ?> | <a
                    href="<?php echo $GLOBALS["fb_mdp_plugin_report_bugs"] ?>">Request
                    Features &
                    Report Issues</a>
            </div>
        </div>

    </form>

</div>