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

<link rel="stylesheet" href="<?php echo ($GLOBALS["fb_mdp_plugin_directory"]) ?>/settings/style.css" />

<!-- TODO: Implement instant preview -->
<!-- <script defer src="script.js"></script> -->
<!-- <script defer src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
<!-- <script defer src="https://cdn.rawgit.com/bgrins/TinyColor/master/tinycolor.js"></script> -->


<meta name="theme-color" content="#fff">
<div class='wrap'>
    <?php
    if (curl_exists() and $github_latest_release != "v" . $GLOBALS["fb_mdp_plugin_version"]) {
        echo '
        <div class="update-nag notice notice-warning inline"><a href="' . $GLOBALS["fb_mdp_plugin_github"] . '/releases/tag/' . $github_latest_release . '">' . $GLOBALS["fb_mdp_plugin_settings_title"] . ' ' . $github_latest_release . '</a> is available! <a href="' . $GLOBALS["fb_mdp_plugin_github"] . '/releases" aria-label="Please update Material Design Dashboard now">Please update now</a>.</div>
        ';
    }
    ?>
    <div class='mdwp-card mdwp-elevation1 mdwp-primary-back mdwp-card-header'>
        <div class='mdwp-header-title'>
            <?php echo $GLOBALS["fb_mdp_plugin_settings_title"] ?>
        </div>
        Developed by <a href="<?php echo $GLOBALS["fb_mdp_plugin_author_website"] ?>"><?php echo $GLOBALS["fb_mdp_plugin_author"] ?></a>
        | Version
        <?php echo $GLOBALS["fb_mdp_plugin_version"] ?> | <a href="<?php echo $GLOBALS["fb_mdp_plugin_report_bugs"] ?>">Request
            Features &
            Report Issues</a>
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
                        echo get_local_file_contents('options/corners.php');
                        echo get_local_file_contents('options/font.php');
                        echo get_local_file_contents('options/header_serif.php');
                        echo get_local_file_contents('options/icons.php');
                        // echo get_local_file_contents('options/toolbar.php');
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