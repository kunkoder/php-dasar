
# :triangular_ruler: Design

Folder ini berisi penerapan design untuk studi kasus media sosial sederhana. Materi yang dibahas meliputi:
* Design database
* Design interface

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall beberapa tools:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Template argon design system

> Note: template argon design system dapat didownload [disini](https://github.com/creativetimofficial/argon-design-system).

## :floppy_disk: Design Database

* Buat database di MySQL dengan nama `sosmed`.
* Buat tabel `user` di dalam database sosmed seperti gambar berikut.
  ![alt text](https://github.com/kunkoder/php-dasar/blob/master/tabel_user.png?raw=true)
* Buat tabel `post` di dalam database sosmed seperti gambar berikut.
* Klik tab `desainer` dan relasikan antara kolom `id` pada tabel user dengan kolom `user_id` pada tabel post. Hasil relasi akan tampak seperti gambar berikut.

## :rainbow: Design Interface



## :open_file_folder: Struktur Folder Argon Design System

```text
├── assets
│   └── ...
├── admin.html
├── edit.html
├── index.html
├── login.html
├── profile.html
└── register.html
```

## :open_file_folder: Struktur Folder Terkini

```text
├── assets
│   └── ...
├── admin.html
├── config.php
├── edit.html
├── index.php
├── login.php
├── profile.html
└── register.php
```

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.