
# :closed_lock_with_key: Authentication

Folder ini berisi penerapan autentifikasi pada bahasa pemrograman PHP. Materi yang dibahas meliputi:
* Login
* Logout
* Register

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P1-Design

**Struktur Folder P1-Design**

```text
├── assets
│   └── ...
├── images
│   └── ...
├── README.md
├── admin.html
├── edit.html
├── index.html
├── login.html
├── profile.html
├── register.html
└── sosmed.sql
```

> Note: folder `images` dan file `sosmed.sql` dapat dihapus.

## :computer: Langkah Kerja

* Buat file `config.php` yang nanti berisi pengaturan database dan beberapa fungsi yang dapat diakses oleh file lainnya.

	**config.php**
	```bash
	<?php

	// (host, username, password, database)
	$conn = mysqli_connect("localhost", "root", "", "sosmed");

	// Memeriksa apakah database terhubung
	if(!$conn) {
		echo"
		<script>
			alert('Database tidak terhubung');
		</script>";
	}

	// Memeriksa apakah query berhasil, bernilai > 0 jika berhasil dan < 0 jika gagal
	function commit($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		$affected = mysqli_affected_rows($conn);
		return $affected; // Mengembalikan nilai > 0 atau < 0
	}

	// Mengambil 1 baris data
	function findOne($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
		return $row; // Mengembalikan array 1 dimensi
	}
	```
	
	* `$conn = mysqli_connect("localhost", "root", "", "sosmed");` berfungsi membuat koneksi dengan MySQL dengan nama host `localhost`, username MySQL `root`,  tanpa password, dan nama database `sosmed`.
	* `if(!$conn)` memeriksa apakah variabel `$conn` menyimpan pengaturan koneksi ke database dengan benar, jika database tidak terhubung maka script dibawahnya dijalankan. 
	* `function commit($query)` adalah fungsi dengan nilai balik berupa nilai > 0 jika berhasil dan < 0 jika gagal, fungsi ini membutuhkan parameter `$query` yang berisi query MySQL. 
	* `function findOne($query)` adalah fungsi dengan nilai balik berupa array asosiatif 1 dimensi, fungsi ini juga membutuhkan parameter `$query` yang berisi query MySQL. 
 
* Ubah format file `register.html`, `login.html`, `index.html` menjadi `.php`.
* Tambahkan script di baris pertama file `register.php`, jangan lupa ubah tombol `<a href="login.html">` menjadi `<a href="login.php">`.

	**register.php**
	```bash
	<?php
		require "config.php";

		// Memeriksa method post yang dikirim ke halaman ini
		if(isset($_POST["register"])) {
			$username = $_POST["username"];
			$email = $_POST["email"];

			// Enkripsi password
			$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

			$user = findOne("SELECT * FROM user WHERE username = '$username'");
			if($user != null) {
				echo"
				<script>
					alert('Username telah terdaftar, pilih username lain');
					document.location.href = 'register.php';
				</script>";
			}
			else {
				$create_user = commit("INSERT INTO user SET role = 'member', username = '$username', email = '$email', password = '$password'");
				if($create_user > 0) {
					echo"
					<script>
						alert('Register berhasil');
						document.location.href = 'login.php';
					</script>";
				}
				else {
					echo"
					<script>
						alert('Register gagal');
						document.location.href = 'register.php';
					</script>";
				}
			}
		}
	?>

	<!-- Skip -->

	<div class="text-center">
        <button type="submit" class="btn btn-primary mt-4" name="register">Buat
            Akun</button>
    </div>
    <div class="text-center">
        <a class="nav-link mt-3" href="login.php">Sudah punya akun?</a>
    </div>
	```
	
	* `if(isset($_POST["register"]))` memeriksa method post yang dikirimkan ke halaman ini dari `<button type="submit" name="register">` yang ada di akhir form. 
	* `$username  =  $_POST["username"];` mengambil data dari `<input type="text" name="username">` dan memasukannya ke variabel `$username`. 
	* `$password  =  password_hash($_POST["password"], PASSWORD_DEFAULT);` menggunakan algoritma bcrypt secara default untuk mengenkripsi password.
	* `$user  =  findOne("SELECT  *  FROM user WHERE username = '$username'");` mengambil 1 baris data dari tabel user dengan kriteria `username = '$username'`.
	* `$create_user  =  commit("INSERT  INTO user SET  role  = 'member', username = '$username', email = '$email', password  = '$password'");` menambahkan 1 baris data ke tabel user dan mengembalikan nilai > 0 jika berhasil dan < 0 jika gagal.
	* `<a href="login.php">` pindah ke halaman `login.php`.

* Tambahkan script di baris pertama file `login.php`, jangan lupa ubah tombol `<a href="register.html">` menjadi `<a href="register.php">`.

	**login.php**
	```bash
	<?php
		require "config.php";
		session_start();

		// Memeriksa method post yang dikirim ke halaman ini
		if(isset($_POST["login"])) {
			$username = $_POST["username"];
			$password = $_POST["password"];

			$user = findOne("SELECT * FROM user WHERE username = '$username'");
			if($user != null) {

				// Memeriksa apakah password benar
				if(password_verify($password, $user["password"])) {

					// Membuat session login berupa id user
					$_SESSION["login"] = $user["id"];

					// Login ke halaman admin
					if($user["role"] == "admin") {
						$_SESSION["admin"] = true;
						echo"
						<script>
							document.location.href = 'admin.php';
						</script>";
					}
					else {
						echo"
						<script>
							document.location.href = 'index.php';
						</script>";
					}
				}
				else {
					echo"
					<script>
						alert('Password salah');
						document.location.href = 'login.php';
					</script>";
				}
			}
			else {
				echo"
				<script>
					alert('Username belum terdaftar, silahkan register');
					document.location.href = 'login.php';
				</script>";
			}
		}
	?>

	<!-- Skip -->

	<div class="text-center">
        <button type="submit" class="btn btn-primary mt-4"
            name="login">Masuk</button>
    </div>
    <div class="text-center">
        <a class="nav-link mt-3" href="register.php">Belum punya akun?</a>
    </div>
	```
	
	* `session_start();` mengizinkan halaman mengakses variabel `$_SESSION` untuk pengecekan autentifikasi.
	* `if(isset($_POST["login"]))` memeriksa method post yang dikirimkan ke halaman ini dari `<button type="submit" name="login">` yang ada di akhir form. 
	* `if(password_verify($password, $user["password"]))` memeriksa isi variabel `$password` cocok dengan password terenkripsi dari `$user["password"]` pada kolom password tabel user.
	* `$_SESSION["login"] =  $user["id"];` membuat session dengan nama login yang berisi id user.
	* `if($user["role"] ==  "admin")` memeriksa kolom role pada tabel user, jika role admin maka akan login ke halaman admin.
	* `$_SESSION["admin"] =  true;` membuat session dengan nama admin yang bernilai true agar user biasa tidak bisa mengakses halaman admin.
	* `<a href="register.php">` pindah ke halaman `register.php`.

* Tambahkan script di baris pertama file `index.php`, jangan lupa ubah tombol `<a href="###">` menjadi `<a href="?logout">`.

	**index.php**
	```bash
	<?php
		require "config.php";
		session_start();

		// Memeriksa user logout atau belum login
		if(!isset($_SESSION["login"]) || isset($_GET["logout"])) {
			session_destroy();
			echo"  
			<script>
				document.location.href = 'login.php';
			</script>";
		}
	?>

	<!-- Skip -->

	<li class="nav-item">
		<a href="?logout" class="nav-link" role="button">
			<i class="ni ni-user-run d-lg-none"></i>
			<span class="nav-link-inner--text">Logout</span>
		</a>
	</li>
	```
	
	* `session_start();` mengizinkan halaman mengakses variabel `$_SESSION` untuk pengecekan autentifikasi.
	* `if(!isset($_SESSION["login"])  ||  isset($_GET["logout"]))` memeriksa apakah ada session yang tersimpan atau method get dengan nama `logout` yang terkirim ke halaman ini untuk mencegah user yang belum login atau yang sudah logout untuk mengakses halaman. User akan otomatis terlempar ke halaman login.
	* `session_destroy();` menghapus session.
	* `<a href="?logout">` mengirimkan method get dengan nama `logout` ke halaman ini.

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.