
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
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/tabel_user.png)
* Buat tabel `post` di dalam database sosmed seperti gambar berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/tabel_post.png)
* Klik tab `desainer` dan relasikan antara kolom `id` pada tabel user dengan kolom `user_id` pada tabel post. Hasil relasi akan tampak seperti gambar berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/relasi_database.png)

## :pushpin: Design Interface

**Struktur Template Argon Design System**

```text
├── assets
│   └── ...
├── docs
│   └── ...
├── examples
│   └── ...
├── CHANGELOG.md
├── ISSUE_TEMPLATE.md
├── LICENSE.md
├── README.md
├── bower.json
├── composer.json
├── gulpfile.js
├── index.html
└── package.json
```

* Buka file index.html dan edit tag `<head>` dan `<script>` sesuai kebutuhan.

    **index.html**
    ```bash
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="assets/img/favicon.png">
        <title>
            Home . Argon
        </title>

        <!-- Nucleo Icons -->
        <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

        <!-- CSS Files -->
        <link href="assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
    </head>

    <!-- Skip -->

	<script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
	<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
    ```

* Hapus isi dari tag `<body>` dan sesuaikan tampilan sesuai kebutuhan. Tampilan `index.html` akan tampak seperti berikut.
  ![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/index.png)
* Salin `index.html` dan buatlah halaman:
    * register.html
    * login.html
    * profile.html
    * admin.html
    * edit.html

> Note: folder `examples`, `docs`, dan beberapa file yang tidak dibutuhkan dapat dihapus.

## :eyes: Preview

**register.html**
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/register.png)

**login.html**
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/login.png)

**profile.html**
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/profile.png)

**admin.html**
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/admin.png)

**edit.html**
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/edit.png)
