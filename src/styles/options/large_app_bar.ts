/*
 *   large_app_bar.ts
 *   material-design-dashboard
 * 
 *   Created by codespace on 5/24/23
 *   Copyright © 2023 Fatih Balsoy. All rights reserved.
 */

// TODO: Do this in PHP instead
window.onload = function () {
    var wrap = document.getElementById("wpwrap")
    var largeAppBar = document.createElement("div")
    largeAppBar.className = "large-app-bar"
    wrap.insertBefore(largeAppBar, wrap.childNodes[1])
}

