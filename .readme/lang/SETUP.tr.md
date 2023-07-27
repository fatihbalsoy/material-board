<!-- BU DOSYA OTOMATİK OLARAK OLUŞTURULMUŞTUR. LÜTFEN `.readme/lang/SETUP.base.md` DOSYASINI DÜZENLEYİN VE `npm run mmg` KOMUTUNU ÇALIŞTIRIN. -->

# Geliştirici Ortamını Kur

[![Build Status](https://img.shields.io/github/actions/workflow/status/fatihbalsoy/wp-material-design/build.yml)](https://github.com/fatihbalsoy/wp-material-design/actions/workflows/build.yml)

Gerekli İşletim Sistemi: Linux, macOS veya Windows (WSL)

Windows kullanıcıları, Ubuntu için uyarlanmış adımları takip etme üzere Linux için Windows Alt Sistemini kurmalıdır. Talimatlar [burada](https://learn.microsoft.com/tr-tr/windows/wsl/install) bulunabilir.

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

## NPM Betikleri

- Bağımlılıkları yükleyin
  - `npm install`
- WebAssembly ve SQLite kullanarak yerel sunucuyu localhost:* (WordPress Playground) üzerinde çalıştırın
  - `npm run dev:wasm`
  - (~/.wp-now altında wp ortamını oluşturur)
- Docker kullanarak yerel sunucuyu localhost:8000 (WordPress) ve localhost:8080 (phpMyAdmin) üzerinde çalıştırın
  - `npm run dev:docker`
- WordPress sunucusu barındırmadan kaynak kodunu izle ve derle
  - `npm run dev`
- Üretim için build/ dizininde derleme yapın
  - `npm run build`
- Her dile ayrı üretim için build/ dizininde derleme yapın
  - `npm run build:lang`

## wp-now

Farklı WordPress ve PHP sürümlerini çalıştırın

```bash
wp-now start --path=build/ --wp=6.3 --php=8.0
```

### Varsayılan Kullanıcı Kimlik Bilgileri

Kullanıcı adı: `admin`

Şifre: `password`
