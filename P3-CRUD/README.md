
# :memo: CRUD

Folder ini berisi penerapan create dan read data dengan bahasa pemrograman PHP. Materi yang dibahas meliputi:
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

* Ubah format file `admin.html` menjadi `.php`.
* Tambahkan script di file `config.php`.

	**config.php**
	```bash
	// Skip

	// Mengambil lebih dari 1 baris data
	function findAll($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		$rows = [];
		while($row = mysqli_fetch_assoc($result)) {
			array_push($rows, $row);
		}
		return $rows; // Mengembalikan array 2 dimensi
	}
	```

	* `function findAll($query)` adalah fungsi dengan nilai balik berupa array asosiatif 2 dimensi, fungsi ini membutuhkan parameter `$query` yang berisi query MySQL.
	* `while($row = mysqli_fetch_assoc($result))` mengambil tiap baris data dari tabel dan menjadikannya array asosiatif.
	* `array_push($rows, $row);` menempatkan tiap baris data dari tabel yang berupa array asosiatif ke dalam variabel `$rows` sehingga variabel `$rows` menjadi array asosiatif 2 dimensi. 

* Buat akun user baru dan ubah role nya menjadi admin secara manual lewat phpmyadmin.
![alt text](https://raw.githubusercontent.com/kunkoder/php-dasar/master/images/ubah_role.png)

* Tambahkan script di baris pertama file `admin.php`.

	**admin.php**
	```bash
	<?php
		require "config.php";
		session_start();

		// Memeriksa user logout atau belum login
		if(!isset($_SESSION["login"]) || isset($_GET["logout"]) || !isset($_SESSION["admin"])) {
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

	* `if(!isset($_SESSION["login"]) || isset($_GET["logout"]) || !isset($_SESSION["admin"]))` memeriksa apakah ada session yang tersimpan atau method get dengan nama `logout` yang terkirim ke halaman ini untuk mencegah user yang belum login atau yang sudah logout untuk mengakses halaman. User akan otomatis terlempar ke halaman login. Script ini juga mencegah user yang rolenya bukan admin untuk mengakses halaman. 

* Tambahkan script di file `index.php`.

	**index.php**
	```bash
	<?php
		require "config.php";
		session_start();
		date_default_timezone_set("Asia/Jakarta");

		// Memeriksa user logout atau belum login
		if(!isset($_SESSION["login"]) || isset($_GET["logout"])) {
			session_destroy();
			echo"
			<script>
				document.location.href = 'login.php';
			</script>";
		}

		$user_id = $_SESSION["login"];
		$user = findOne("SELECT * FROM user WHERE id = '$user_id'");

		// Relasi antara tabel user dan post
		$posts = findAll("SELECT u.*, p.* FROM post p INNER JOIN user u WHERE p.user_id=u.id ORDER BY created_at DESC");
		
		// Memeriksa method post yang dikirim ke halaman ini
		if(isset($_POST["post"])) {
			$content = $_POST["content"];
			$created_at = date("Y-m-d H:i:s");

			$create_post = commit("INSERT INTO post SET user_id='$user_id', content='$content', created_at='$created_at'");
			if($create_post < 0) {
				echo"
				<script>
					alert('Post gagal dikirim');
					document.location.href = 'index.php';
				</script>";
			}
			echo"
			<script>
				document.location.href = 'index.php';
			</script>";
		}
	?>

	<!-- Skip -->

	<?php foreach($posts as $post) : ?>
		<div class="row py-3 align-items-center">
			<div class="col-sm-3 text-center">

				<?php if($post["avatar"] != null) : ?>
					<img src="avatar/<?= $post["avatar"]; ?>" alt="Rounded image" class="img-fluid rounded shadow"
						width="120">
				<?php else : ?>
					<img src="assets/img/faces/team-1.jpg" alt="Rounded image" class="img-fluid rounded shadow"
						width="120">
				<?php endif; ?>
						
			</div>
			<div class="col-sm-9">
				<p class="font-weight-bold">
					<?= $post["username"]; ?>
					<small class="text-muted"><?= $post["created_at"]; ?></small>
				</p>
				<p><?= $post["content"]; ?></p>
			</div>
		</div>
	<?php endforeach; ?>
	```
	
	* `date_default_timezone_set("Asia/Jakarta");` mengatur penanggalan ke waktu Kota Jakarta atau GMT +7.
	* `$user_id = $_SESSION["login"];` mengambil data session dengan nama login yang berisi id user.
	* `$user = findOne("SELECT * FROM user WHERE id = '$user_id'");` mengambil 1 baris data dari tabel user dengan kriteria `id = '$user_id'`.
	* `$posts = findAll("SELECT u.*, p.* FROM post p INNER JOIN user u WHERE p.user_id=u.id ORDER BY created_at DESC");` mengambil lebih dari 1 baris data dari relasi tabel user dan post dengan kriteria `id` yang di tabel user sama dengan `user_id` yang di tabel post`.
	* `if(isset($_POST["post"]))` memeriksa method post yang dikirimkan ke halaman ini dari `<button type="submit" name="post">` yang ada di akhir form.
	* `$created_at = date("Y-m-d H:i:s");` mengambil data waktu terkini dengan format `tahun-bulan-tanggal jam:menit:detik` agar bisa dimasukan ke kolom `created_at` dengan tipe datetime di tabel post.
	* `$create_post = commit("INSERT INTO post SET user_id='$user_id', content='$content', created_at='$created_at'");` menambahkan 1 baris data ke tabel post dan mengembalikan nilai > 0 jika berhasil dan < 0 jika gagal.
	* `<?php foreach($posts as $post) : ?>` perulangan yang menguraikan variabel `$posts` yang berupa array asosiatif 2 dimensi sehingga tiap baris dapat diakses melalui variabel `$post`.
	* `<?php if($post["avatar"] != null) : ?>` jika user belum mempunyai foto profile, maka akan menampilkan foto profile default.

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.