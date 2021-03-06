
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

		// Memeriksa user logout atau belum login
		if(!isset($_SESSION["login"])  ||  isset($_GET["logout"])) {
			session_destroy();
			echo"
			<script>
				document.location.href = 'login.php';
			</script>";
		}
	?>
	```
	
	* `session_start();` mengizinkan halaman mengakses variabel `$_SESSION` untuk pengecekan autentifikasi.
	* `if(!isset($_SESSION["login"])  ||  isset($_GET["logout"]))` mencegah user yang belum login atau yang sudah logout untuk mengakses halaman.
	* `session_destroy();` menghapus session.

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.