
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

## :pushpin: Design Database

* Buat database di MySQL dengan nama `sosmed`.
* Buat tabel `user` di dalam database sosmed seperti gambar berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/P1-Design/tabel_user.png)
* Buat tabel `post` di dalam database sosmed seperti gambar berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/P1-Design/tabel_post.png)
* Klik tab `desainer` dan relasikan antara kolom `id` pada tabel user dengan kolom `user_id` pada tabel post. Hasil relasi akan tampak seperti gambar berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/P1-Design/relasi_database.png)

## :pushpin: Design Interface



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