/*
 *   watch.ts
 *   material-board
 * 
 *   Created by Fatih Balsoy on 5/31/23
 *   Copyright © 2023 Fatih Balsoy. All rights reserved.
 */

const fs = require("fs")
const { exec } = require("child_process")

const directories = [
    "src/",
    "src/assets/",
    "src/languages/",
    "src/settings/",
    "src/settings/options/",
]
console.log("Listening for file changes at:")
for (const i in directories) {
    const directory = directories[i]
    console.log("- ", directory)
    fs.watch(directory, function (event, filename) {
        const date = Date()
        console.log(`[${date}] Source file changed:`, filename)
        if (directory == 'src/languages/') {
            exec('zsh scripts/compile_languages.sh')
        } else {
            exec('bash scripts/copy_files.sh') // , (err, stdout, stderr) => { }
        }
    })
}