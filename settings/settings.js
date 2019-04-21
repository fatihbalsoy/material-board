var rad = document.themeForm.theme;
var prev = null;

var blankDarkTheme = '../wp-content/plugins/bits-custom-admin-theme/assets/dark-theme/blank.css';
var darkTheme = '../wp-content/plugins/bits-custom-admin-theme/assets/dark-theme/dark-theme.css';

for (var i = 0; i < rad.length; i++) {
	rad[i].onclick = function () {
		(prev) ? console.log(prev.value) : null;
		if (this !== prev) {
			prev = this;
		}
		console.log(this.value);
		if (this.value == 'dark') {
			changeCSS(darkTheme, blankDarkTheme);
		} else if (this.value == 'light') {
			changeCSS(blankDarkTheme, darkTheme);
		}
	};
}

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
	} else if (selectedFont == 'product-sans') {
		html.style.setProperty("--font-type", "Product Sans");
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

	document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);
}