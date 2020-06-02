<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Setup

- Letakkan folder ini di root aplikasi jamaah
- Masuk ke folder ini via terminal
- Jalankan "php artisan migrate"
- Jalankan server "php artisan serve"

## Untuk menambah travel baru
- Isi form http://localhost:8000/sites/create nama, slug, dst. Klik submit.
- Masukkan file logo utama di folder [root]/assets/img/logo
- Masukkan file icon mipmap android ke folder res/mipmap
- Buat folder baru dalam ke [root]ios/Runner/Assets.xcassets/AppIcon.appiconset/icon sesuai nama slug-nya
- Masukkan file icon set iOS dalam folder tsb.
- Buat folder baru di dalam [root]ios/googleserviceplist sesuai nama slug-nya
- Generate file GoogleService-Info.plist dari firebase console sesuai iOS bundle ID yang baru, lalu masukkan ke folder tsb
- Generate file google-services.json dari firebase console sesuai Android applicationId yang baru, masukkan ke folder tsb [root]/android/app/

## Di Browser
- Buka http://localhost:8000/sites
- Pilih salah satu travel dan klik Edit
- Jika perlu ada perubahan di metadata, klik "Save" dulu sebelum "Build"
- Klik button build untuk mem-build otomatis aab dan ios nya.
- Untuk android file aab ter-generate di folder [flutter project root]/build/app/outputs/bundle/release dan bisa langsung diupload
- Untuk iOS bisa langsung dilakukan archiving secara manual kemudian diupload


