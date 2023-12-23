
<!-- THIS FILE IS AUTO-GENERATED. PLEASE EDIT `.readme/lang/SETUP.base.md` AND RUN `npm run mmg`. -->

# Setup Developer Environment
[![Build Status](https://img.shields.io/github/actions/workflow/status/fatihbalsoy/material-board/build.yml)](https://github.com/fatihbalsoy/material-board/actions/workflows/build.yml)

Required Operating System: Linux, macOS, or Windows (WSL)

Windows users must setup Windows Subsystem for Linux to follow the steps tailored for Ubuntu. Instructions can be found [here](https://learn.microsoft.com/en-us/windows/wsl/install).

1. Download and install [Node.js](https://nodejs.org/en/download/)
1. Run `npm install` on this directory
1. Install Zsh for running scripts
    - **Ubuntu**: `sudo apt install zsh`
    - **macOS**: Default shell for macOS 10.15+
1. Install `wp-now` globally to run Wordpress with WebAssembly
    - `npm i -g @wp-now/wp-now`
1. Install `gettext` for language translation (optional)
    - **Ubuntu**: `sudo apt install gettext`
    - **macOS**: `brew install gettext`
1. Install `mmg` to generate multilingual markdown files (optional)
    - **Ubuntu**: `pip3 install mmg --user`
        - Add local binaries to environment path: `export PATH="$HOME/.local/bin:$PATH"`
    - **macOS**: `sudo pip3 install mmg` or follow Ubuntu instructions, find binary location and add to path.
1. Run any of the npm scripts to get started.
    - `npm run` to list all scripts.

## NPM Scripts
- Install dependencies
  - `npm install`
- Run the local server at localhost:* (WordPress Playground) using WebAssembly and SQLite
  - `npm run dev:wasm`
  - (creates wp environment at ~/.wp-now)
- Run the local server at localhost:8000 (WordPress) and localhost:8080 (phpMyAdmin) using Docker
  - `npm run dev:docker`
- Watch & compile source code without hosting a WordPress server
  - `npm run dev`
- Build for production in the build/ directory
  - `npm run build`
- Build with development flag in the build/ directory
  - `npm run build:dev`
- Create a tag in the SVN repo for the current build
  - `npm run svn:tag`
- Reset SVN repo
  - `npm run svn:reset`

## wp-now

Run different versions of WordPress and PHP

```bash
wp-now start --path=build/ --wp=6.3 --php=8.0
```

### Default User Credentials

Username: `admin`

Password: `password`
