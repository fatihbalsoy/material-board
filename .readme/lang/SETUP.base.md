<!---------------------------->
<!-- multilingual suffix: en, tr -->
<!-- no suffix: en -->
<!---------------------------->

<!-- [en] -->
<!-- THIS FILE IS AUTO-GENERATED. PLEASE EDIT `.readme/lang/SETUP.base.md` AND RUN `npm run mmg`. -->

<!-- [tr] -->
<!-- BU DOSYA OTOMATİK OLARAK OLUŞTURULMUŞTUR. LÜTFEN `.readme/lang/SETUP.base.md` DOSYASINI DÜZENLEYİN VE `npm run mmg` KOMUTUNU ÇALIŞTIRIN. -->

<!-- [en] -->
# Setup Developer Environment
<!-- [tr] -->
# Geliştirici Ortamını Kur

<!-- [common] -->
[![Build Status](https://img.shields.io/github/actions/workflow/status/fatihbalsoy/material-board/build.yml)](https://github.com/fatihbalsoy/material-board/actions/workflows/build.yml)

<!-- [en] -->
Required Operating System: Linux, macOS, or Windows (WSL)

Windows users must setup Windows Subsystem for Linux to follow the steps tailored for Ubuntu. Instructions can be found [here](https://learn.microsoft.com/en-us/windows/wsl/install).

<!-- [tr] -->
Gerekli İşletim Sistemi: Linux, macOS veya Windows (WSL)

Windows kullanıcıları, Ubuntu için uyarlanmış adımları takip etme üzere Linux için Windows Alt Sistemini kurmalıdır. Talimatlar [burada](https://learn.microsoft.com/tr-tr/windows/wsl/install) bulunabilir.

<!-- [en] -->
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

<!-- [tr] -->
1. [Node.js](https://nodejs.org/tr/download) indirin ve kurun
1. Bu dizinde `npm install` komutunu çalıştırın
1. Komut dosyalarını çalıştırmak için Zsh'yi yükleyin
     - **Ubuntu**: `sudo apt install zsh`
     - **macOS**: macOS 10.15+ için varsayılan kabuk
1. Wordpress'i WebAssembly ile çalıştırmak için 'wp-now'u global olarak kurun
     - `npm i -g @wp-now/wp-now`
1. Dil çevirisi için gettext'i kurun (isteğe bağlı)
     - **Ubuntu**: `sudo apt install gettext`
     - **macOS**: `brew install gettext`
1. Çok dilli markdown dosyaları oluşturmak için "mmg" yükleyin (isteğe bağlı)
     - **Ubuntu**: `pip3 install mmg --user`
         - Ortam yoluna yerel ikili dosyalar ekleyin: `export PATH="$HOME/.local/bin:$PATH"`
     - **macOS**: `sudo pip3 install mmg` veya Ubuntu talimatlarını takip edin, ikili konumu bulun ve yola ekleyin.
1. Başlamak için herhangi bir npm betiğini çalıştırın.
     - Tüm betikleri listelemek için `npm run`.

<!-- [en] -->
## NPM Scripts
<!-- [tr] -->
## NPM Betikleri

<!-- [en] -->
- Install dependencies
  - `npm install`
- Run the local server at localhost:* (WordPress Playground) using WebAssembly and SQLite
  - `npm run dev:wasm`
  - (creates wp environment at ~/.wp-now)
- Run the local server at localhost:8080 (WordPress) and localhost:8081 (phpMyAdmin) using Docker
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

<!-- [tr] -->
- Bağımlılıkları yükleyin
  - `npm install`
- WebAssembly ve SQLite kullanarak yerel sunucuyu localhost:* (WordPress Playground) üzerinde çalıştırın
  - `npm run dev:wasm`
  - (~/.wp-now altında wp ortamını oluşturur)
- Docker kullanarak yerel sunucuyu localhost:8080 (WordPress) ve localhost:8081 (phpMyAdmin) üzerinde çalıştırın
  - `npm run dev:docker`
- WordPress sunucusu barındırmadan kaynak kodunu izle ve derle
  - `npm run dev`
- Üretim için build/ dizininde derleme yapın
  - `npm run build`
- Geliştirme bayrağıyla build işlemi build/ dizininde oluştur
  - `npm run build:dev`
- Mevcut yapı için SVN deposunda bir etiket oluştur
  - `npm run svn:tag`
- SVN deposunu sıfırla
  - `npm run svn:reset`

<!-- [common] -->
## wp-now

<!-- [en] -->
Run different versions of WordPress and PHP

<!-- [tr] -->
Farklı WordPress ve PHP sürümlerini çalıştırın

<!-- [common] -->
```bash
wp-now start --path=build/ --wp=6.3 --php=8.0
```

<!-- [en] -->
### Default User Credentials

Username: `admin`

Password: `password`

<!-- [tr] -->
### Varsayılan Kullanıcı Kimlik Bilgileri

Kullanıcı adı: `admin`

Şifre: `password`

<!-- [common] -->
## phpMyAdmin (Docker)

<!-- [en] -->
### Default Credentials

Username: `wp_user`

Password: `wp_password`

<!-- [tr] -->
### Varsayılan Kimlik Bilgileri

Kullanıcı adı: `wp_user`

Şifre: `wp_password`
