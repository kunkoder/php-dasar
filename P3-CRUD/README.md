
# :closed_lock_with_key: CRUD

Folder ini berisi penerapan create dan read data pada bahasa pemrograman PHP. Materi yang dibahas meliputi:
* Menambah data
* Menampilkan data
* Relasi antar tabel

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P2-Authentication

**Struktur Folder P2-Authentication**

```text
├── assets
│   └── ...
├── README.md
├── admin.html
├── edit.html
├── index.php
├── login.php
├── profile.html
├── register.php
└── sosmed.sql
```

## :computer: Langkah Kerja

* Tambahkan script di file `index.php`.

	**index.php**
	```bash
	<?php
		require  "config.php";
		session_start();

	?>
	```
	
	* ``

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.