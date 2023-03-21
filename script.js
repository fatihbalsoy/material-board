/*
 *   script.js
 *   wp-material-design
 * 
 *   Created by codespace on 3/21/23
 *   Copyright © 2023 Fatih Balsoy. All rights reserved.
 */

if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.cookie = 'system_theme=dark; expires=Fri, 1 Jan 9999 00:00:00 UTC; path=/'
} else {
    document.cookie = 'system_theme=light; expires=Fri, 1 Jan 9999 00:00:00 UTC; path=/'
}