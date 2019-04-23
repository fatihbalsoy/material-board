var blankDarkTheme = '../wp-content/plugins/bits-custom-admin-theme/assets/dark-theme/blank.css';
var darkTheme = '../wp-content/plugins/bits-custom-admin-theme/assets/dark-theme/dark-theme.css';
var tinyColorGit = 'https://cdn.rawgit.com/bgrins/TinyColor/master/tinycolor.js';

function preloadFunc() {
	jQuery.getJSON("/wp-content/plugins/bits-custom-admin-theme/settings/options.json", function (json) {
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

		function getCssLink(cssFile){
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
			} else if (selectedFont == 'productsans') {
				html.style.setProperty("--font-type", "Product Sans");
			} else {
				html.style.setProperty("--font-type", "unset");
			}
		}
		changePrimaryColor();
		changeAccentColor();
		changeFontType();
	});
}
window.onpaint = preloadFunc();