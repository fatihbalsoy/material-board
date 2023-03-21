/*
 *   properties.js
 *   assets
 * 
 *   Created by Fatih Balsoy on 2/2/20
 *   Last Modified by Fatih Balsoy on 7/17/20
 *   Copyright © 2020 Fatih Balsoy. All rights reserved.
 */

var blankDarkTheme = '../wp-content/plugins/material-design-dashboard/assets/dark-theme/blank.css';
var darkTheme = '../wp-content/plugins/material-design-dashboard/assets/dark-theme/dark-theme.css';
var tinyColorGit = 'https://cdn.rawgit.com/bgrins/TinyColor/master/tinycolor.js';

if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.cookie = 'system_theme=dark; expires=Fri, 1 Jan 9999 00:00:00 UTC; path=/'
} else {
    document.cookie = 'system_theme=light; expires=Fri, 1 Jan 9999 00:00:00 UTC; path=/'
}

// TODO: Remove later
jQuery.ajax({
    url: '/wp-content/plugins/material-design-dashboard/script.php',
    success: function (data) {
        // $('.result').html(data);
        console.log(data);
    }
});

function preloadFunc() {
    jQuery.getJSON("/wp-content/plugins/material-design-dashboard/settings/options.json", function (json) {
        console.log(json);
        function getValue(key, json) {
            var value = json[key];
            return value;
        }

        const isDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches
        if (isDarkMode) {
            var lightTheme = document.getElementsByTagName("link").item(blankDarkTheme);
            lightTheme.replaceWith(getCssLink(darkTheme));

            console.log("Set theme to dark");
        } else {
            if (getValue("theme", json) == "dark") {
                changeCSS(darkTheme, blankDarkTheme);
                console.log("Set theme to dark");
            } else {
                changeCSS(blankDarkTheme, darkTheme);
                console.log("Set theme to default");
            }
        }

        var colors = getValue("colors", json);

        function changeCSS(cssFile, cssLinkIndex) {
            if (!isDarkMode) {
                var oldlink = document.getElementsByTagName("link").item(cssLinkIndex);
                oldlink.replaceWith(getCssLink(cssFile));
            }
        }

        function getCssLink(cssFile) {
            var newlink = document.createElement("link");
            newlink.setAttribute("rel", "stylesheet");
            newlink.setAttribute("type", "text/css");
            newlink.setAttribute("href", cssFile);
            return newlink;
        }

        var html = document.getElementsByTagName('html')[0];
        function changePrimaryColor() {
            var hexcolor = getValue("primary", colors);
            html.style.setProperty("--primary-color", hexcolor);
            console.log("Primary color set to " + hexcolor);
            //document.querySelector('meta[name="theme-color"]').setAttribute('content', hexcolor);
            findColorForText("primary", hexcolor);
        }
        function changeAccentColor() {
            var hexcolor = getValue("accent", colors);
            html.style.setProperty("--accent-color", hexcolor);
            console.log("Accent color set to " + hexcolor);
            findColorForText("accent", hexcolor);
        }
        function findColorForText(name, hexcolor) {
            jQuery.getScript(tinyColorGit, function () {
                var color = tinycolor(hexcolor);
                if (color.isLight()) {
                    html.style.setProperty("--" + name + "-color-text", "#000");
                    console.log("Accent text color set to #000");
                } else if (color.isDark()) {
                    html.style.setProperty("--" + name + "-color-text", "#fff");
                    console.log("Accent text color set to #fff");
                }
            });

        }

        function changeFontType() {
            var selectedFont = getValue("font", json);
            if (selectedFont == 'roboto') {
                html.style.setProperty("--font-type", "Roboto");
            } if (selectedFont == 'mona-sans') {
                html.style.setProperty("--font-type", "Mona Sans");
            } if (selectedFont == 'hubot-sans') {
                html.style.setProperty("--font-type", "Hubot Sans");
            } else {
                html.style.setProperty("--font-type", "unset");
            }
        }
        changePrimaryColor();
        changeAccentColor();
        changeFontType();
    });
}
// window.onpaint = preloadFunc();