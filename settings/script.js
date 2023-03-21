/*
 *   settings.js
 *   settings
 * 
 *   Created by Fatih Balsoy on 4/21/19
 *   Last Modified by Fatih Balsoy on 7/17/20
 *   Copyright © 2020 Fatih Balsoy. All rights reserved.
 */

// var script = document.createElement('script');
// script.src = 'https://code.jquery.com/jquery-3.6.3.min.js';
// document.getElementsByTagName('head')[0].appendChild(script);
// $(document).ready(function () {
// 	$(window).keydown(function (event) {
// 		if (event.keyCode == 13) {
// 			event.preventDefault();
// 			return false;
// 		}
// 	});
// });

// var rad = document.mdp_theme.theme;
var prev = null;

var blankDarkTheme = '../wp-content/plugins/material-design-dashboard/assets/dark-theme/blank.css';
var darkTheme = '../wp-content/plugins/material-design-dashboard/assets/dark-theme/dark-theme.css';

var blankMaterialIcons = '../wp-content/plugins/material-design-dashboard/assets/material-icons/blank.css';
var materialIcons = '../wp-content/plugins/material-design-dashboard/assets/material-icons/material-icons.css';

// for (var i = 0; i < rad.length; i++) {
// 	rad[i].onclick = function () {
// 		(prev) ? console.log(prev.value) : null;
// 		if (this !== prev) {
// 			prev = this;
// 		}
// 		console.log(this.value);
// 		if (this.value == 'dark') {
// 			changeCSS(darkTheme, blankDarkTheme);
// 		} else if (this.value == 'light') {
// 			changeCSS(blankDarkTheme, darkTheme);
// 		}
// 	};
// }

var html = document.getElementsByTagName('html')[0];
function changePrimaryColor() {
	var hexcolor = document.getElementById('primary-color').value;
	html.style.setProperty("--primary-color", hexcolor);
	document.querySelector('meta[name="theme-color"]').setAttribute('content', hexcolor);
	findColorForText("primary", hexcolor);
}
function changeAccentColor() {
	var hexcolor = document.getElementById('accent-color').value;
	html.style.setProperty("--accent-color", hexcolor);
	findColorForText("accent", hexcolor);
}
function findColorForText(name, hexcolor) {
	var color = tinycolor(hexcolor);
	if (color.isLight()) {
		html.style.setProperty("--" + name + "-color-text", "#000");
		console.log("Accent text color set to #000");
	} else if (color.isDark()) {
		html.style.setProperty("--" + name + "-color-text", "#fff");
		console.log("Accent text color set to #fff");
	}
}
function changeFontType() {
	var selectedFont = document.getElementById("font-face").value;
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
function changeIcons() {
	var selectedIcon = document.getElementById("icon-fonts").value;
	if (selectedIcon == 'md-icons') {
		console.log('Material Icons');
		changeCSS(materialIcons, blankMaterialIcons);
	} else {
		console.log('WordPress DashIcons');
		changeCSS(blankMaterialIcons, materialIcons);
	}
}

function changeCSS(cssFile, cssLinkIndex) {
	var oldlink = document.getElementsByTagName("link").item(cssLinkIndex);

	var newlink = document.createElement("link");
	newlink.setAttribute("rel", "stylesheet");
	newlink.setAttribute("type", "text/css");
	newlink.setAttribute("href", cssFile);

	oldlink.replaceWith(newlink);
}