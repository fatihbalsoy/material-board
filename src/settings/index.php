<!--
* index.php
* settings
*
* Created by Fatih Balsoy on 4/14/23
* Copyright © 2023 Fatih Balsoy. All rights reserved.
-->

<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

// TODO: Replace this function
function fbwpmdp_get_local_file_contents($file_path)
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
    curl_setopt($ch, CURLOPT_URL, $GLOBALS["fbwpmdp_github_releases"]);

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
<?php
wp_enqueue_style('mdp-plugin-settings-page-stylesheet', plugins_url('style.css', __FILE__));
?>

<!-- TODO: Implement instant preview -->
<div class='wrap'>
    <!-- Update Banner -->
    <?php
    if (curl_exists() and $github_latest_release != "v" . $GLOBALS["fbwpmdp_version"]) {
        echo '
        <div class="update-nag notice notice-warning inline"><a href="' . $GLOBALS["fbwpmdp_github"] . '/releases/tag/' . $github_latest_release . '">' . $GLOBALS["fbwpmdp_settings_title"] . ' ' . $github_latest_release . '</a> is available! <a href="' . $GLOBALS["fbwpmdp_github"] . '/releases" aria-label="Please update Material Board now">Please update now</a>.</div>
        ';
    }
    ?>

    <!-- HEADER -->
    <!-------------------------------------------------------------------------------->
    <!-- Material Board                                                         -->
    <!-------------------------------------------------------------------------------->
    <div>
        <h1 class='wp-heading-inline'>
            <?php echo esc_html_e('Material Board', 'material-board') ?>
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
                <h3 class='mdwp-card-title'>
                    <?php esc_html_e('Appearance', 'material-board') ?>
                </h3>
                <table class='form-table'>
                    <tbody>
                        <?php
                        // Theme            - Light
                        //                  - Dark
                        //                  - System
                        echo fbwpmdp_get_local_file_contents('options/theme.php');
                        // Colors           - Primary
                        //                  - Accent
                        echo fbwpmdp_get_local_file_contents('options/colors.php');
                        // Rounded Corners  - Checkbox
                        echo fbwpmdp_get_local_file_contents('options/corners.php');
                        // Font             - DM Sans
                        //                  - Roboto
                        //                  - Mona Sans
                        //                  - Hubot Sans
                        //                  - Wordpress Default
                        echo fbwpmdp_get_local_file_contents('options/font.php');
                        // Header Serif     - Checkbox
                        echo fbwpmdp_get_local_file_contents('options/header_serif.php');
                        // Icons            - Material Icons
                        //                  - Wordpress Dashicons
                        echo fbwpmdp_get_local_file_contents('options/icons.php');
                        // Large App Bar    - Checkbox
                        //                  - Options
                        //                      - Admin Bar on Top
                        //                      - Admin Menu on Top
                        echo fbwpmdp_get_local_file_contents('options/large_app_bar.php');
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Save Changes -->
            <?php
            submit_button();
            ?>
            <!-- FOOTER -->
            <!-- Developed by [Author] | Version | Request Features & Report Issues | Help translate this page         -->
            <div>
                <?php esc_html_e('Developed by', 'material-board') ?>
                <a href="<?php echo esc_attr($GLOBALS["fbwpmdp_author_website"]) ?>"><?php echo esc_attr($GLOBALS["fbwpmdp_author"]) ?></a>
                | <?php esc_html_e('Version', 'material-board') ?>
                <?php echo esc_attr($GLOBALS["fbwpmdp_version"]) ?> | <a href="<?php echo esc_attr($GLOBALS["fbwpmdp_report_bugs"]) ?>">
                    <?php esc_html_e('Request Features & Report Issues', 'material-board') ?></a> | 
                    <a href="<?php echo esc_attr($GLOBALS["fbwpmdp_crowdin"]) ?>"><?php esc_html_e('Help translate this page', 'material-board') ?></a>
            </div>
        </div>

    </form>

</div>